<div class="modal fade" id="btn-OrderDelete-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form class="modal-content" id="DeleteOrder" name="DeleteOrder" method="POST">
             @method('DELETE')
             @csrf  
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-trash-alt order-number pr-3">取消訂單</i></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body delete-body">
                <span>確定要取消<span class="font-weight-bold order-number"></span>這筆訂單嗎？</span>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn bg-red">確定</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">離開</button>
            </div>
        </form>
    </div>
</div>