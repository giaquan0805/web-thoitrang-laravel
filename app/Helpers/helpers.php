<?php

function product_image($path)
{
    if (!$path) return asset('images/no-image.jpg');
    
    // Ảnh mới upload qua storage
    if (file_exists(public_path('storage/' . $path))) {
        return asset('storage/' . $path);
    }
    
    // Ảnh cũ trong public/images
    return asset($path);
}