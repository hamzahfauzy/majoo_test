<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-fullscreen">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Buat Produk Baru</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-12 col-md-6">
            <h4>Detail Produk</h4>
            <form action="" id="form-create" onsubmit="saveCat(); return false;">
              <input type="hidden" name="user" value="{{Auth::user()->id}}">
              <div class="form-group mb-3">
                <label for="">Kategori</label>
                <select name="categories[]" id="" class="select2 form-control" multiple required>
                  @foreach($categories as $category)
                  <option value="{{$category->id}}">{{$category->name}}</option>
                  @endforeach
                </select>
              </div>

              <div class="form-group mb-3">
                <label for="">Nama</label>
                <input type="text" name="name" id="" class="form-control" required>
              </div>
    
              <div class="form-group mb-3">
                <label for="">Deskripsi</label>
                <textarea type="text" name="description" id="editor" class="form-control"></textarea>
              </div>
    
              <div class="form-group mb-3">
                <label for="">Harga</label>
                <input type="number" name="price" id="" class="form-control" required>
              </div>
    
              <div class="form-group">
                <label for="">Stok</label>
                <input type="number" name="qty" id="" value="0" class="form-control" required>
              </div>
            </form>
          </div>
          <div class="col-12 col-md-6">
            <h4>Gambar Produk</h4>
            <div class="d-flex mb-4">
              <input type="file" name="image_upload" id="image_upload" multiple class="d-none" accept="image/*" onchange="appendImage(event)">
              <button class="btn btn-primary" onclick="image_upload.click()">Upload Gambar</button>
            </div>
            <div class="progress mb-4" style="display:none">
              <div class="progress-bar" id="upload-progress" role="progressbar" aria-valuenow="0"
              aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div id="image-preview" class="d-flex align-content-start flex-wrap"></div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary btn-save" onclick="saveCat()">Submit</button>
      </div>
    </div>
  </div>
</div>