<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Files List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-4">
    <h1>Files in FTP Directory</h1>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ basename($file) }}</td>
                    <td>
                        <a href="{{ route('ftp.download', ['file' => basename($file)]) }}" class="btn btn-primary">Download</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
