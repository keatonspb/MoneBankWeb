<div class="modal fade add-credit_pay-dialog" tabindex="-1" role="dialog" xmlns:v-on="http://www.w3.org/1999/xhtml">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Погасить задолжность</h4>
            </div>
            <form method="get" class="ajaxform" action="/api/credit_pay">
                <div class="modal-body">
                    <div class="alert alert-danger" style="display: none;"></div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Сумма</label>
                                <input class="form-control" name="sum" value="0" type="number"/>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                    <button class="btn btn-primary" type="submit">Сохранить</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


