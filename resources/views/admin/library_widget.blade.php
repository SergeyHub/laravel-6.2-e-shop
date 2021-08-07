<p class="text-right">
    <i class="fa fa-product-hunt"></i>
    <span class="product-{{$product->remote_id}} name">{{$product->name}}</span>
    <span class="small text-muted">CRM ID: <b>{{$product->remote_id}}</b></span>
</p>
&nbsp;

<a title="Открыть в библиотеке" class="btn btn-warning"
   href="{{\App\Services\API\LibraryConnector::relayLink($product->remote_id)}}"
   target="_blank">
    <i class="fa fa-cubes"></i>
    Открыть в библиотеке
</a>

<div class="btn-group">
    <span class="btn product-{{$product->remote_id}} stock" title="Остаток">
        <i class="fa fa-cubes"></i>
        <span class="value">

        </span>

    </span>
    <label class="btn product-{{$product->remote_id}} status" title="Статус">
        <i class="fa fa-power-off"></i>
        <span class="value">

        </span>
    </label>
    <span class="btn btn-default product-{{$product->remote_id}} rating"><i class="fa fa-star" title="Рейтинг"></i>
         <span class="value">

        </span>
    </span>
</div>

<label class="btn bg-green product-{{$product->remote_id}} promote" title="Хит" style="display: none">
    <i class="fa fa-star"></i>
</label>
<label class="btn bg-orange product-{{$product->remote_id}} preorder" title="Предзаказ" style="display: none">
    <i class="fa fa-phone"></i>
</label>
<label class="btn  bg-red product-{{$product->remote_id}} status_hide" title="Скрыт" style="display: none">
    <i class="fa fa-eye"></i>
</label>
|
<script type="text/javascript" src="{{\App\Services\API\LibraryConnector::widgetLink($product->remote_id)}}"></script>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
        let product = product_{{$product->remote_id}} || false;
        let cls = ".product-{{$product->remote_id}}";

        if (product)
        {
            $(cls+".name").text(product.name);
            //stock
            $(cls+".stock .value").text(product.stock);
            if(product.stock > 10)
            {
                $(cls+".stock").addClass("bg-green");
            }
            if(product.stock <= 10 && product.stock > 0)
            {
                $(cls+".stock").addClass("bg-orange");
            }
            if(product.stock === 0)
            {
                $(cls+".stock").addClass("bg-red");
            }

            //status
            if(product.status_mode === 2)
            {
                $(cls+".status").addClass("bg-green");
                $(cls+".status .value").text("Включен");
            }
            if(product.status_mode === 1)
            {
                $(cls+".status").addClass("bg-blue");
                $(cls+".status .value").text("Автоматически");
            }
            if(product.status_mode === 0)
            {
                $(cls+".status").addClass("bg-green");
                $(cls+".status .value").text("Включен");
            }

            //rating
            $(cls+".rating .value").text(product.rating);
            $(cls+".stock .value").text(product.stock);

            //preorder
            if(product.preorder)
            {
                $(cls+".preorder").css("display","inline-block");
            }

            //status
            if(product.status === 0)
            {
                $(cls+".status_hide").css("display","inline-block");
            }

            //promote
            if(product.promote)
            {
                $(cls+".promote").css("display","inline-block");
            }
        }

    });
</script>
