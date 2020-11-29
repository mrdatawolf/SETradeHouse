@if(! empty($goodTypeId) && ! empty($goodId))
    {{ $this->getGoodTitleFromGoodtypeIdAndGoodId($goodTypeId, $goodId) }}
@else
    n/a
@endif
