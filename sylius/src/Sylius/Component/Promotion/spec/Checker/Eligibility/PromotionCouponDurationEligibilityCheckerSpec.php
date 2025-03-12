<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace spec\Sylius\Component\Promotion\Checker\Eligibility;

use PhpSpec\ObjectBehavior;
use Sylius\Component\Promotion\Checker\Eligibility\PromotionCouponEligibilityCheckerInterface;
use Sylius\Component\Promotion\Model\PromotionCouponInterface;
use Sylius\Component\Promotion\Model\PromotionSubjectInterface;

final class PromotionCouponDurationEligibilityCheckerSpec extends ObjectBehavior
{
    function it_is_a_promotion_coupon_eligibility_checker(): void
    {
        $this->shouldImplement(PromotionCouponEligibilityCheckerInterface::class);
    }

    function it_returns_true_if_promotion_coupon_does_not_expire(
        PromotionSubjectInterface $promotionSubject,
        PromotionCouponInterface $promotionCoupon,
    ): void {
        $promotionCoupon->getExpiresAt()->willReturn(null);

        $this->isEligible($promotionSubject, $promotionCoupon)->shouldReturn(true);
    }

    function it_returns_true_if_promotion_coupon_has_not_expired_yet(
        PromotionSubjectInterface $promotionSubject,
        PromotionCouponInterface $promotionCoupon,
    ): void {
        $promotionCoupon->getExpiresAt()->willReturn(new \DateTime('tomorrow'));

        $this->isEligible($promotionSubject, $promotionCoupon)->shouldReturn(true);
    }

    function it_returns_false_if_promotion_coupon_has_already_expired(
        PromotionSubjectInterface $promotionSubject,
        PromotionCouponInterface $promotionCoupon,
    ): void {
        $promotionCoupon->getExpiresAt()->willReturn(new \DateTime('yesterday'));

        $this->isEligible($promotionSubject, $promotionCoupon)->shouldReturn(false);
    }
}
