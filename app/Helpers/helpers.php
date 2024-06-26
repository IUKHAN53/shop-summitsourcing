<?php
function getProductCategoryName($id) {
    return \App\Models\Category::query()->where('alibaba_id', $id)->first()->name ?? '';
}

function calculateWidth($score) {
    $totalScore = 5;
    return ($score / $totalScore) * 100;
}
