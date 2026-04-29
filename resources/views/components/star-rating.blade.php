@props(['product'])

<?php
$total_rate = DB::table('rates')->where('product_id', $product->id)->sum('star_value');
$total_voter = DB::table('rates')->where('product_id', $product->id)->count();

if ($total_voter > 0) {
    $per_rate = $total_rate / $total_voter;
} else {
    $per_rate = 0;
}

$per_rate = number_format($per_rate, 1);
$whole = floor($per_rate);
$fraction = $per_rate - $whole;
?>

<span class="product_rating">
    @for($i = 1; $i <= $whole; $i++)
        <i class="fa fa-star"></i>
    @endfor

    @if($fraction != 0)
        <i class="fa fa-star-half"></i>
    @endif
                                        
    <span class="rating_avg">({{ $per_rate }})</span>
</span>
<br>
