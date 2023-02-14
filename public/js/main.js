// @ts-nocheck
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $('.create-tag-button').click(createTag);
    $('.tags__block').on('click', '.delete-tag-button', deleteTag);

    function createTag() {
        const name = $('input.create-tag-input').val();

        if($('.create-tag-button').data('from')) {
            return attachToTodo(name, $(this).data('from'));
        }

        $.post({
            url: "/tag/create",
            data: { name },
            success: addTag,
            statusCode: { 422: handleValidationError }
        });
    }

    function attachToTodo(name, id) {
        $.post({
            url: `${id}/tag/attach`,
            data: name
        })
    }

    function addTag(response) {
        const parentExists = $('.tags__list').length;
        const item = createTagItem(response);

        if (parentExists) {
            $('.tags__list').append(item);
        } else {
            const list = `<div class="tags__list">${item}</div>`;
            $('.tags__block').prepend(list).find('i').remove();
        }

        $('input.create-tag-input').val('');
    }

    function createTagItem(response) {
        return `
        <span class="tag-item" data-tag="${response.tag.id}">
          <span class="tag-name">${response.tag.name}</span>
          <span class="delete-tag-button">&times;</span>
        </span>
      `;
    }

    function handleValidationError() {
        $('input.create-tag-input').addClass('is-invalid')

        setTimeout(() => {
            $('input.create-tag-input').removeClass('is-invalid')
        }, 1000);
    }

    function deleteTag() {
        const parent = $(this).parent();

        $.post({
            url: "/tag/delete",
            data: { tagId: parent.data('tag') },
            success: function (response) {
                parent.remove();
            }
        });
    }

    $('.status-button').click(function () {
        const btn = $(this);
        const todoId = btn.data('id');
        const completed = btn.data('completed');

        $.post({
            url: "/todo/status-toggler",
            data: { todoId, completed },
            success(response) {
                btn.toggleClass('btn-outline-success btn-success');
            }
        });
    });

    $('input.add_image').on('change', function (e) {
        const [file] = this.files;

        if (file) {
            var url = URL.createObjectURL(file);
            $('.todo-image-preview img').attr('src', url);

            $('.todo-image-preview img').on('click', () => {
                window.open(url, '_blank')
            })
            $('.todo-image-preview').show();
        }
    })

    $('.todo-image-preview .cancel').on('click', function() {
        $('.todo-image-preview').hide();
    });

    $('.todo-image-preview .upload').on('click', function() {
        var todo_id = location.href.slice('-1');

        let blobUrl = $('.todo-image-preview img').attr('src');
        fetch(blobUrl)
        .then(res => res.blob())
        .then(blob => {
          const file = new File([blob], 'filename.jpg', { type: blob.type });

          const formData = new FormData();
          formData.append('file', file);

          $.post({
            url: `${todo_id}/image/upload`,
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                location.reload();
            }
        });
        });
    });
});
