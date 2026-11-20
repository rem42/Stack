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

namespace Tests\Sylius\ShadcnAdminUi\Functional;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

final class FlashesTest extends KernelTestCase
{
    use RendersTwigTrait;

    public function testFlashesAreShownWhenTheSessionHasNoAttribute(): void
    {
        // Session is Countable and only counts its attributes: here it counts 0.
        $session = new Session(new MockArraySessionStorage());
        $session->start();
        $session->getFlashBag()->add('success', 'Book has been saved.');
        self::assertCount(0, $session);

        $request = new Request();
        $request->setSession($session);
        /** @var RequestStack $requestStack */
        $requestStack = self::getContainer()->get('request_stack');
        $requestStack->push($request);

        $crawler = $this->crawl("{% include '@SyliusShadcnAdminUi/shared/crud/common/content/flashes.html.twig' %}");

        self::assertStringContainsString('Book has been saved.', $crawler->filter('[data-test-sylius-flashes-container]')->text());
    }

    public function testNothingIsRenderedWithoutASession(): void
    {
        self::assertSame('', trim($this->render("{% include '@SyliusShadcnAdminUi/shared/crud/common/content/flashes.html.twig' %}")));
    }
}
