<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use App\Models\Book;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use ApiResponseTrait;

    public function index(Book $book)
    {
        $reviews = $book->reviews()->paginate(2);

        return response()->json([
            "reviews" => ReviewResource::collection($reviews),
            "current_page" => $reviews->currentPage(),
            "last_page" => $reviews->lastPage(),
            "per_page" => $reviews->perPage()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Book $book)
    {

        $user = request()->user("sanctum");

        function alreadyCreated($user, $book) {
            foreach ($user->reviews as $review) {
                if ($review->book_id === $book->id) {
                    return true;
                }
            }
            return false;
        }

        if (alreadyCreated($user, $book)) {
            return response()->json([
                "message" => "Вы уже создавали отзыв на эту книгу"
            ]);
        }


        $validator = validator(request()->all(), [
            "rating" => "required|integer|min:0|max:10",
            "text" => "required|string|regex:/[а-яёА-ЯЁ,.!@#$%^&*()!\"№;%:?*'`]+/u|min:20"
        ]);

        if ($validator->fails()) return $this->validation(errors: $validator->errors());

        $data = $validator->validated();


        $data["user_id"] = $user->id;
        $data["book_id"] = $book->id;

        Review::create($data);

        return response()->json([
            "code" => 201,
            'message' => "Отзыв добавлен"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Book $book)
    {
        $user = \request()->user("sanctum");

        function getReview($user, $book) {
            foreach ($book->reviews as $review) {
                if ($review->user_id === $user->id) {
                    return $review;
                }
            }

            return null;
        }

        $review = getReview($user, $book);

        if (!$review) {
            return $this->forbidden();
        }

        $validator = validator(request()->all(), [
            "rating" => "nullable|integer|min:0|max:10",
            "text" => [
                "nullable",
                "string",
                "regex:/^[а-яё\s.,!?;:\-\"\()]+$/ui",
                "min:20"
            ]
        ]);

        if ($validator->fails()) return $this->validation(errors: $validator->errors());

        $data = $validator->validated();

        $review->update($data);

        return response()->json([
            "code" => 200,
            'message' => "Отзыв изменен"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $user = \request()->user("sanctum");

        function getReview($user, $book) {
            foreach ($book->reviews as $review) {
                if ($review->user_id === $user->id) {
                    return $review;
                }
            }

            return null;
        }

        $review = getReview($user, $book);

        if (!$review) {
            return $this->forbidden();
        }

        $review->delete();

        return response()->json([
            "message" => "Отзыв удален",
            "code" => 200
        ]);

    }
}
