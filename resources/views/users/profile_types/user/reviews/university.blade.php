<div class="review__container">
    @if($user->userUniversityReviews->count())
        <div class="reviews_items">
            @foreach($user->userUniversityReviews as $review)
                <div class="review_item">

                    <div class="review__top_side">
                        <div class="review__left_side">
                            <p class="pre__review_name">Ваш Отзыв Учебному заведению</p>
                            <a href="/university/{{ $review->university->university->id }}" target="_blank" class="review__name">{{  $review->university->university->full_name }}</a>
                        </div>

                        <div class="stars stars-example-fontawesome">
                            <select class="rating-stars" name="rating" data-readonly="true" data-current-rating="{{ $review['rating'] }}" autocomplete="off">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>

                    </div>

                    <div class="review__message">
                        {{ $review['review'] }}
                    </div>
                    @if(!$review['confirm'])
                        <span class="on__moderation">На модерации</span>
                    @else
                        <p class="review__date">Отзыв опубликован {{ date('d.m.Y H:i', strtotime($review['created_at'])) }}</p>
                        <br>
                        <a href="{{ route(userRoute('review_delete'), ['id' => $review->id]) }}?type=university" class="btn btn2 confirm__item">Удалить</a>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <div class="no__data">
            <h5>Нет отзывов</h5>
        </div>
    @endif
</div>
