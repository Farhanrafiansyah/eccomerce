<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'price', 'image', 'stock'];

    /**
     * Get the image URL for the product
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            // If image path exists, return the storage URL
            if (file_exists(public_path('storage/' . $this->image))) {
                return asset('storage/' . $this->image);
            }
        }
        
        // Fallback to a default product image or placeholder
        return $this->getPlaceholderImage();
    }

    /**
     * Get placeholder image based on product name or a default
     */
    private function getPlaceholderImage()
    {
        // Generate different placeholder images based on product keywords
        $productImages = [
            'iphone' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop&auto=format',
            'samsung' => 'https://images.unsplash.com/photo-1565849904461-04a58ad377e0?w=400&h=300&fit=crop&auto=format',
            'galaxy' => 'https://images.unsplash.com/photo-1565849904461-04a58ad377e0?w=400&h=300&fit=crop&auto=format',
            'macbook' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&h=300&fit=crop&auto=format',
            'laptop' => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=400&h=300&fit=crop&auto=format',
            'dell' => 'https://images.unsplash.com/photo-1593640408182-31c70c8268f5?w=400&h=300&fit=crop&auto=format',
            'phone' => 'https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=400&h=300&fit=crop&auto=format',
            'computer' => 'https://images.unsplash.com/photo-1547082299-de196ea013d6?w=400&h=300&fit=crop&auto=format',
            'ipad' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=300&fit=crop&auto=format',
            'tablet' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400&h=300&fit=crop&auto=format',
        ];

        $productName = strtolower($this->name);
        
        foreach ($productImages as $keyword => $imageUrl) {
            if (str_contains($productName, $keyword)) {
                return $imageUrl;
            }
        }
        
        // Default fallback image for electronics
        return 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400&h=300&fit=crop&auto=format';
    }
}
