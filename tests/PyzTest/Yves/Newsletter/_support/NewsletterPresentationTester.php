<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace PyzTest\Yves\Newsletter;

use Codeception\Actor;
use Orm\Zed\Newsletter\Persistence\SpyNewsletterSubscriber;
use Orm\Zed\Newsletter\Persistence\SpyNewsletterSubscription;
use Orm\Zed\Newsletter\Persistence\SpyNewsletterTypeQuery;
use Spryker\Shared\Newsletter\NewsletterConstants;

/**
 * Inherited Methods
 *
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(\PyzTest\Yves\Newsletter\PHPMD)
 */
class NewsletterPresentationTester extends Actor
{
    use _generated\NewsletterPresentationTesterActions;

    /**
     * @param string $email
     *
     * @return void
     */
    public function haveAnAlreadySubscribedEmail($email): void
    {
        $newsletterSubscriberEntity = new SpyNewsletterSubscriber();
        $newsletterSubscriberEntity
            ->setEmail($email)
            ->save();

        $newsletterTypeEntity = SpyNewsletterTypeQuery::create()
            ->findOneByName(NewsletterConstants::DEFAULT_NEWSLETTER_TYPE);

        $newsletterSubscriptionEntity = new SpyNewsletterSubscription();
        $newsletterSubscriptionEntity
            ->setSpyNewsletterType($newsletterTypeEntity)
            ->setSpyNewsletterSubscriber($newsletterSubscriberEntity)
            ->save();
    }
}
