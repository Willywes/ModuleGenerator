<div class="row">
    <div class="col-md-12">
        {{--                                <button class="btn btn-primary" onclick="createController();">Create Controller</button>--}}
        <button class="btn btn-info" title="Copiar" onclick="copyContentController();"><i
                class="fa fa-copy"></i></button>
        <button class="btn btn-info" title="Guardar" onclick="$('#storeController').submit();"><i
                class="fa fa-save"></i></button>
    </div>
</div>
<div class="row py-4">
    <div class="col-md-12">
        <form id="storeController" action="{{ route('intranet.modules-generator.storeController') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $object->id }}">
            <textarea id="contentController" class="form-control" rows="30" name="data"></textarea>
        </form>
    </div>
</div>
