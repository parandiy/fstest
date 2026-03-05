@extends('layouts.app')

@section('content')

    <h3 class="mb-4">Upload File</h3>

    <div class="card p-3 mb-4">
        <div id="upload-alert"></div>
        <input type="file" id="fileInput" class="form-control">

        <div class="progress mt-3 d-none">
            <div class="progress-bar" role="progressbar"></div>
        </div>

    </div>

    <h3>Uploaded Files</h3>

    <table class="table table-bordered">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Size</th>
            <th>Expires</th>
            <th></th>
        </tr>
        </thead>

        <tbody id="filesTable">

        @foreach($files as $file)
            <tr id="file-{{$file->id}}">
                <td>{{$file->id}}</td>
                <td>{{$file->original_name}}</td>
                <td>{{round($file->size/1024,2)}} KB</td>
                <td>{{$file->expires_at}}</td>

                <td>
                    <button
                        class="btn btn-danger btn-sm delete-btn"
                        data-id="{{$file->id}}">
                        Delete
                    </button>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>

    {{$files->links()}}

@endsection

@push('scripts')
    <script>

        const csrf = $('meta[name="csrf-token"]').attr('content');

        function showError(message) {
            $('#upload-alert').html(`
        <div class="alert alert-danger alert-dismissible fade show">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);
        }

        function showInfo(message) {
            $('#upload-alert').html(`
        <div class="alert alert-info">
            ${message}
        </div>
    `);
        }

        function parseLaravelError(xhr) {

            if (!xhr.responseJSON) {
                return 'Unexpected server error';
            }

            // validation errors
            if (xhr.responseJSON.errors) {
                return Object.values(xhr.responseJSON.errors)
                .flat()
                .join('<br>');
            }

            // exception message
            if (xhr.responseJSON.message) {
                return xhr.responseJSON.message;
            }

            return 'Upload failed';
        }

        $('#fileInput').on('change', function () {

            let file = this.files[0];

            if (!file) return;

            let formData = new FormData();
            formData.append('file', file);

            $('.progress').removeClass('d-none');
            $('.progress-bar').css('width', '0%');

            showInfo('Uploading file...');

            $.ajax({
                url: "{{ route('files.store') }}",
                method: "POST",
                headers: {'X-CSRF-TOKEN': csrf},
                data: formData,
                processData: false,
                contentType: false,
                timeout: 30000,

                xhr: function () {
                    let xhr = new window.XMLHttpRequest();

                    xhr.upload.addEventListener("progress", function (e) {
                        if (e.lengthComputable) {
                            let percent = (e.loaded / e.total) * 100;
                            $('.progress-bar')
                            .css('width', percent + '%')
                            .text(Math.round(percent) + '%');
                        }
                    });

                    return xhr;
                },

                success: function () {
                    location.reload();
                },

                error: function (xhr) {

                    $('.progress').addClass('d-none');
                    $('.progress-bar')
                    .css('width', '0%')
                    .text('');

                    let message = '';

                    if (xhr.status === 413) {
                        message = 'File is too large. Maximum size is 10MB.';
                    } else if (xhr.status === 0) {
                        message = 'Network error. Check your internet connection.';
                    } else {
                        message = parseLaravelError(xhr);
                    }

                    showError(`<strong>Upload failed:</strong><br>${message}`);
                }
            });

        });

    </script>

    <script>

        $(document).on('click', '.delete-btn', function () {

            if (!confirm('Delete file?')) return;

            let id = $(this).data('id');

            $.ajax({
                url: `/${id}`,
                method: "DELETE",
                headers: {'X-CSRF-TOKEN': csrf},

                success: function () {
                    $(`#file-${id}`).remove();
                }
            });

        });
    </script>
@endpush
