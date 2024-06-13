<?php
function getProductCategoryName($id) {
    return \App\Models\Category::query()->where('alibaba_id', $id)->first()->name ?? '';
}
