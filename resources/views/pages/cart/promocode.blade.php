<form action="{{promocode() ? route("promocode.remove") : route("promocode.apply")}}" method="post" class="promocode">
    {{csrf_field()}}
    <div class="promocode__title mb-2 pt-1">Введите промокод</div>
    <label class="small text-danger error js-promocode-error" for="code"></label>
    @if(promocode())
        <input class="form-control w-100 px-4 mb-4" name="code" value="{{promocode()->code}}" readonly>
        <button class="btn btn-light btn-lg w-100">Удалить промокод</button>
    @else
        <input class="form-control w-100 px-4 mb-4" name="code" placeholder="Введите код" required value="{{old("promocode")}}">
        <button class="btn btn-dark w-100">Применить промокод</button>
    @endif
</form>
