namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserRating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    
    public function rate(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = UserRating::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $product->id],
            ['rating' => $request->rating, 'rating_datetime' => now()]
        );

        return response()->json(['message' => 'Rating saved', 'data' => $rating]);
    }

 
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $existing = UserRating::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$existing) {
            return response()->json(['message' => 'No existing rating to update'], 404);
        }

        $existing->update([
            'rating' => $request->rating,
            'rating_datetime' => now(),
        ]);

        return response()->json(['message' => 'Rating updated', 'data' => $existing]);
    }

   
    public function remove(Request $request, Product $product)
    {
        $deleted = UserRating::where('user_id', $request->user()->id)
            ->where('product_id', $product->id)
            ->delete();

        if (!$deleted) {
            return response()->json(['message' => 'No rating found'], 404);
        }

        return response()->json(['message' => 'Rating removed']);
    }

    
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $products = Product::withAvg('ratings', 'rating')->get()->map(function ($product) use ($userId) {
            $userRating = $product->ratings()->where('user_id', $userId)->first();

            $timePassed = null;
            $activeTime = null;

            if ($userRating) {
                $timePassed = now()->diffInMinutes($userRating->rating_datetime);
                $activeTime = $timePassed > 30 ? 'active' : 'inactive';
            }

            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'ratings' => round($product->ratings_avg_rating ?? 0, 2),
                'user_rating' => $userRating->rating ?? null,
                'time_passed' => $timePassed,
                'active_time' => $activeTime,
            ];
        });

        return response()->json($products);
    }
}