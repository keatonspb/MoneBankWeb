<div class="modal fade add-bill-dialog" tabindex="-1" role="dialog" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Потратить</h4>
            </div>
            <form method="get" class="bill_form" action="/api/bill">
                <input type="hidden" class="bill_type" name="type" value=""/>
                <div class="modal-body">
                    <div class="alert alert-danger" style="display: none;"></div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Сумма</label>
                                <input class="form-control" name="sum" value="0" type="number"/>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="credit" value="1"> в кредит
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group reasons">
                                <label>Причина</label>
                                <select class="form-control parent_reason_select" name="reason_id" data-type="expense">
                                    @foreach($reasons as $reason)
                                        <option class="{{$reason->type}}" value="{{$reason->id}}">{{$reason->name}}</option>
                                    @endforeach
                                </select>
                                <select class="form-control sub_reason" name="sub_reason_id">

                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <textarea class="form-control" name="description"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button class="btn btn-primary" type="submit">Потратить</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


