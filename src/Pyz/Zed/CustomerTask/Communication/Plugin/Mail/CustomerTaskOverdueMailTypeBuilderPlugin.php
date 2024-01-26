<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CustomerTask\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \Pyz\Zed\CustomerTask\Business\CustomerTaskFacadeInterface getFacade()
 * @method \Pyz\Zed\CustomerTask\CustomerTaskConfig getConfig()
 */
class CustomerTaskOverdueMailTypeBuilderPlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'CUSTOMER_TASK_NOTIFICATION_MAIL';

    /**
     * @var string
     */
    private const MAIL_TEMPLATE_HTML = 'CustomerTask/mail/overdue-notification.html.twig';

    /**
     * @var string
     */
    private const MAIL_TEMPLATE_TEXT = 'CustomerTask/mail/overdue-notification.text.twig';

    /**
     * @var string
     */
    private const MAIL_SUBJECT = 'Task overdue notification.';

    /**
     * {@inheritDoc}
     * - Returns the name of mail for customer task notification mail.
     *
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return self::MAIL_TYPE;
    }

    /**
     * {@inheritDoc}
     * - Builds the `MailTransfer` with data for customer task notification mail.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function build(MailTransfer $mailTransfer): MailTransfer
    {
        return $mailTransfer
            ->setSubject(self::MAIL_SUBJECT)
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(self::MAIL_TEMPLATE_HTML)
                    ->setIsHtml(true),
            )
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(self::MAIL_TEMPLATE_TEXT)
                    ->setIsHtml(false),
            );
    }
}
