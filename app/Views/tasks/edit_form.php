
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
