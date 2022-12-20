<?php
namespace IGD\Trustpilot\API\BusinessUnit\Review\Product;

use IGD\Trustpilot\API\BusinessUnit\Review;
use IGD\Trustpilot\API\ResourceApi;
use Illuminate\Support\Collection;

class ProductReviewApi extends ResourceApi
{
    /**
     * The business unit id.
     *
     * @var int
     */
    public $businessUnitId = null;

    /**
     * Initialise the business unit product reviews with an optional business unit id.
     * If no business unit id is given, it uses the business unit from the config.
     *
     * @param null|string $businessUnitId
     */
    public function __construct(?string $businessUnitId = null)
    {
        parent::__construct();
        $this->businessUnitId = $businessUnitId ?? config('trustpilot.unit_id');
        $this->setPath('/product-reviews/business-units/' . $this->businessUnitId);
    }

    /**
     * Perform the query and get the results.
     *
     * @param array $query
     * @param bool $search
     * @return \Illuminate\Support\Collection;
     */
    public function perform(array $query, bool $search = false): Collection
    {
        $response = $this->get('/reviews', $query);
        return collect($response->productReviews)->map(function ($productReview) {
            return (new ProductReview())->data($productReview);
        });
    }
}
