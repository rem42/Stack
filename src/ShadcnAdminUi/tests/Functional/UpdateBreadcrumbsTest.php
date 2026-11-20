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

final class UpdateBreadcrumbsTest extends KernelTestCase
{
    use RendersTwigTrait;

    public function testTheResourceLinksToItsShowPageWithACustomIndexRoute(): void
    {
        $configuration = new class() {
            /** @var array<string, mixed> */
            public array $vars = ['index' => ['route' => ['name' => 'app_admin_book_index', 'parameters' => ['category' => 'novel']]]];

            public function getRouteName(string $name): string
            {
                return 'app_admin_book_' . $name;
            }
        };

        $crawler = $this->crawl(
            "{% include '@SyliusShadcnAdminUi/shared/crud/update/content/header/breadcrumbs.html.twig' %}",
            ['hookable_metadata' => [
                'context' => [
                    'configuration' => $configuration,
                    'resource' => ['id' => 16, 'code' => 'dune'],
                    'metadata' => ['applicationName' => 'app', 'pluralName' => 'books'],
                ],
                'configuration' => [],
            ]],
        );

        self::assertSame(
            ['/admin/', '/admin/books?category=novel', '/admin/books/16'],
            $crawler->filter('a[data-slot="breadcrumb-link"]')->each(static fn ($link): string => (string) $link->attr('href')),
        );
    }
}
