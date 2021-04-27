<div class="modal fade" id="btn-ChangeStatus-modal" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
            <form class="modal-content" action="{{route('order.status')}}" method="POST">
                  <input type="hidden" id="ord_hash" name="ord_hash" value="">
                   @csrf
                 <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">變更訂單狀態</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                 </div>
                 <div class="modal-body">
                       <div class="form-group"> 
                           <label class="d-block"><div class="alert alert-primary" role="alert">選擇訂單狀態</div></label>
                                <div class="d-flex">
                                      @foreach($types as $id => $type)
                                      @if($id<4)
                                      <div class="custom-control custom-radio flex-fill">
                                          <input type="radio" id="status{{ $id }}" name="status" class="custom-control-input" value="{{$id}}" required>
                                              <label class="custom-control-label" for="status{{$id}}">
                                                  <h3><span class="badge
                                                            @if($id==0)
                                                            badge-secondary
                                                            @elseif($id==1)
                                                            badge-primary
                                                            @elseif($id==2)
                                                            badge-success
                                                            @elseif($id==3)
                                                            badge-danger
                                                            @endif ">
                                                            {{$type}}
                                                        </span>
                                                  </h3>
                                              </label>
                                        </div> 
                                      @endif
                                      @endforeach
                                  </div>
                            </div>
                      </div> 
              <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">返回</button>
              <button type="submit" class="btn btn-primary">確定</button>
              </div>
        </form>
    </div>
</div>