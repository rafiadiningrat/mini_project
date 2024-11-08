<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>
<body>
    <h1>Daftar Tugas</h1>

    <form id="form-tambah">
        <input type="text" name="judul" placeholder="Judul Tugas" required>
        <button type="submit">Tambah Tugas</button>
    </form>


    <table id="task-table" class="display">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
    </table>

    <div id="form-edit-container" style="display:none;">
        <h2>Edit Tugas</h2>
        <form id="form-edit-tugas">
            <input type="hidden" id="edit-id" name="id">
            <input type="text" id="edit-judul" name="judul" placeholder="Judul Tugas" required>
            <select id="edit-status" name="status" required>
                <option value="0">Belum Selesai</option>
                <option value="1">Selesai</option>
            </select>
            <button type="submit">Simpan Perubahan</button>
            <button type="button" id="cancel-edit">Batal</button>
        </form>
    </div>

    <script>
        $(document).ready(function () {

    const table = $('#task-table').DataTable({
        ajax: { 
            url: '/tasks/getAll',  
            dataSrc: ''  
        },
        columns: [
            { data: 'judul' },
            { 
                data: 'status', 
                render: function(data) {

                    return `<input type="checkbox" ${data == 1 ? 'checked' : ''} class="status-checkbox">`;
                }
            },
            { 
                data: 'id', 
                render: function(data) {
                    return `<button class="edit-btn" data-id="${data}">Edit</button>
                            <button class="delete-btn" data-id="${data}">Delete</button>`;
                }
            }
        ]
    });



            
            $('#task-table').on('click', '.edit-btn', function () {
    const id = $(this).data('id');

    
    $.get(`/tasks/editForm/${id}`, function (response) {
        
        if (response.status === 'success') {
            
            $('#edit-id').val(response.data.id);
            $('#edit-judul').val(response.data.judul);
            $('#edit-status').val(response.data.status);  

            
            $('#form-edit-container').show();
        } else {
            alert('Tugas tidak ditemukan.');
        }
    });
});

            
            $(document).on('submit', '#form-edit-tugas', function (e) {
                e.preventDefault();

                
                $.post('/tasks/edit', $(this).serialize(), function (response) {
                    if (response.status === 'success') {
                      
                        table.ajax.reload();
                        $('#form-edit-container').hide();
                    } else {
                        alert('Gagal mengupdate tugas.');
                    }
                });
            });

            
            $(document).on('click', '#cancel-edit', function () {
                $('#form-edit-container').hide();
            });

            
            $('#form-tambah').submit(function (e) {
                e.preventDefault();
                $.post('/tasks/add', $(this).serialize(), function (response) {
                    if (response.status === 'success') {
                        table.ajax.reload();
                        $('#form-tambah')[0].reset();
                    }
                });
            });

            
            $('#task-table').on('change', '.status-checkbox', function () {
                const status = $(this).is(':checked') ? 1 : 0;
                const id = $(this).closest('tr').find('.delete-btn').data('id');
                $.post('/tasks/update', { id, status }, function (response) {
                    if (response.status === 'success') {
                        table.ajax.reload();
                    }
                });
            });

            
            $('#task-table').on('click', '.delete-btn', function () {
                const id = $(this).data('id');
                $.post('/tasks/delete', { id }, function (response) {
                    if (response.status === 'success') {
                        table.ajax.reload();
                    }
                });
            });
        });
    </script>
</body>
</html>
