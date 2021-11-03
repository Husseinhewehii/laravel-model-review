# Model-Review: Laravel Package
[![Latest Stable Version](https://poser.pugx.org/dgvai/laravel-user-review/v/stable)](https://packagist.org/packages/hewehi/laravel-model-review)
[![Total Downloads](https://poser.pugx.org/dgvai/laravel-user-review/downloads)](https://packagist.org/packages/hewehi/laravel-model-review)
[![Latest Unstable Version](https://poser.pugx.org/dgvai/laravel-user-review/v/unstable)](https://packagist.org/packages/hewehi/laravel-model-review)
[![License](https://poser.pugx.org/dgvai/laravel-user-review/license)](https://packagist.org/packages/hewehi/laravel-model-review)

This package is derived from **Jalal Uddin**'s beautiful package [Github](https://github.com/dgvai-git) | [Linked-in](https://linkedin.com/in/dgvai) | [Facebook](https://facebook.com/dgvai.hridoy)
which provides the ability for user to make review on any model on the system with rates and comments,
with the privilege to the user to make more than one review on the same model.

I took it an added a new functionality which aligns with systems that allow users to make only one review on a model or update it.

### My LinkedIn
[Linked-in](https://www.linkedin.com/in/hussein-el-hewehii-768b5a113/)

## Requirements
<ul>
<li>PHP >= 7.1</li>
<li>Laravel >= 5.6</li>
</ul>

## Installation
> using COMPOSER

`` composer require hewehi/laravel-model-review``

## Configurations
> Export the assets (migration and config)

``php artisan vendor:publish --provider="Hewehi\ModelReview\ModelReviewServiceProvider" ``

> Run the migration

``php artisan migrate``

> Clear configuration cache

``php artisan config:cache``

## Usage
Add ``Reviewable`` trait to the model where you want users to give review and ratings. As example for **Product Model** 

```php
<?php 
namespace App;

use Hewehi\ModelReview\Reviewable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Reviewable;
    ...
    ...
}

?>
```

### Creating review for a product:
> Description

``makeReview(object $user, int $rating , string $comment)``

``makeOrUpdateReview(object $user, int $rating , string $comment)``

``comment is optional``

> Returns

``Object instance of the review``

> Example

```php
    $product = Product::find($id);
    $user = auth()->user();

    //user can add new review on this product even they have one
    $product->makeReview($user, 3, 'optional comment');

    //user can only update their review on this product or create a new one if they don't have any reviews yet
    $product->makeOrUpdateReview($user, 3, 'optional comment');
```

### Review attributes
```php
    // Get all active reviews of the product
    $product->reviews();

    // Get neumetic review count (average)
    $product->rating;

    // Get percentage review count (average)
    $product->rating_percent;

    /**
    *   NOTE: THIS PERCENTAGE IS BASED ON 5 STAR RATING, IF YOU WANT CUSTOM STAR, USE BELLOW
    *   This is configured via the config file comes with this package: user-review.php
    *   You can also set environment variable for your systems default star count
    *
    *   (.env)  SYSTEM_RATING_STAR_COUNT=5 
    */

    $product->averageRating(10);    //percentage for 10 starrted model

    // Get rating given to the product by a user:
    $product->userRating($user);

    /**
     *  Get Filtered Review
     *  Like, get only reviews that has been given 4 stars!
     * 
    */

    $product->filter(4);

    /**
     * Get it's percentage, which can be shown in the progress bar!
     * */ 
    $product->filteredPercentage(4);      // ex: output: 75 


    /**
     *  PULLING OUT REVIEWS
     *  There are several ways you can
     *  pull out reviews of products
    */

    // Get all reviews of all products
    $reviews = Hewehi\ModelReview\Review::all();              // all reviews
    $reviews = Hewehi\ModelReview\Review::active()->get();    // all active reviews
    $reviews = Hewehi\ModelReview\Review::inactive()->get();  // all inactive reviews
    $reviews = Hewehi\ModelReview\Review::daily()->get();     // all daily reviews
    $reviews = Hewehi\ModelReview\Review::monthly()->get();   // all monthly reviews
    $reviews = Hewehi\ModelReview\Review::yearly()->get();    // all yearly reviews

    // You can also chain these methods
    $reviews = Hewehi\ModelReview\Review::monthly()->active()->get();  // get aa monthly active reviews

    // Get reviews of a product
    $product->reviews();


    /**
     *  $reviews has some attributes
     *  Let's assume we are taking the first review
    */
    $review = $reviews->first();

    /**
     *  This the model object of the traited model
     *  In our case it is product
     * 
    */

    $review->model;     //  so $review->model->name with return the $product->name
    $review->user;      //  return User model that reviewed the model

    // Get review text
    $review->review_text;

    // Get review reply
    $review->reply;

    // reply a review by admin:
    $review->reply('Thanks for being with us!');

    // making active/inactive
    $review->makeActive();
    $review->makeInactive();

```


