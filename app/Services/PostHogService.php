<?php

namespace App\Services;

use PostHog\PostHog;

class PostHogService
{
    private static bool $initialized = false;

    public function __construct()
    {
        if (config('posthog.disabled') || self::$initialized) {
            return;
        }

        PostHog::init(config('posthog.api_key'), [
            'host' => config('posthog.host'),
        ]);

        self::$initialized = true;
    }

    public function capture(string $event, array $properties = []): void
    {
        if (config('posthog.disabled')) {
            return;
        }

        PostHog::capture([
            'event' => $event,
            'properties' => $properties,
        ]);
    }

    public function identify(string $distinctId, array $properties = []): void
    {
        if (config('posthog.disabled')) {
            return;
        }

        PostHog::identify([
            'distinctId' => $distinctId,
            'properties' => $properties,
        ]);
    }

    public function contextFromHeaders(array $headers): array
    {
        if (config('posthog.disabled')) {
            return [];
        }

        return PostHog::contextFromHeaders($headers);
    }

    public function withContext(array $context, callable $callback): mixed
    {
        if (config('posthog.disabled')) {
            return $callback();
        }

        return PostHog::withContext($context, $callback, ['fresh' => true]);
    }

    public function captureException(\Throwable $exception, ?string $distinctId = null, array $properties = []): void
    {
        if (config('posthog.disabled')) {
            return;
        }

        PostHog::captureException($exception, $distinctId, $properties);
    }
}
