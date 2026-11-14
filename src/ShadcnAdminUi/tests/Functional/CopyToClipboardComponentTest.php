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

final class CopyToClipboardComponentTest extends KernelTestCase
{
    use RendersTwigTrait;

    public function testItRendersTheDefaultClassesUnescaped(): void
    {
        $classes = $this->buttonClasses('<twig:sylius_shadcn_admin_ui:copy_to_clipboard value="x" />');

        self::assertContains("[&_svg:not([class*='size-'])]:size-3", $classes);
        self::assertContains('text-muted-foreground', $classes);
    }

    public function testButtonClassReplacesTheDefaultClasses(): void
    {
        self::assertSame(['my-button'], $this->buttonClasses('<twig:sylius_shadcn_admin_ui:copy_to_clipboard value="x" button_class="my-button" />'));
    }

    public function testClassIsAddedToTheDefaultClasses(): void
    {
        $classes = $this->buttonClasses('<twig:sylius_shadcn_admin_ui:copy_to_clipboard value="x" class="extra" />');

        self::assertSame('extra', end($classes));
        self::assertContains('text-muted-foreground', $classes);
    }

    public function testCopyableAddsTheNestedButtonClass(): void
    {
        $classes = $this->buttonClasses('<twig:sylius_shadcn_admin_ui:copyable value="x" button:class="extra" />');

        self::assertSame('extra', end($classes));
        self::assertContains('text-muted-foreground', $classes);
    }

    /**
     * @return list<string>
     */
    private function buttonClasses(string $template): array
    {
        preg_match('/<button\b[^>]*>/', $this->render($template), $button);
        self::assertSame(1, preg_match_all('/\sclass="/', $button[0] ?? ''), 'The button has a single class attribute.');

        $class = (string) $this->crawl($template)->filter('button')->attr('class');

        return array_values(array_filter(explode(' ', $class)));
    }
}
