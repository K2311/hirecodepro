<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactInquiry>
 */
class ContactInquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $inquiryTypes = ['general', 'service', 'support', 'partnership'];
        $statuses = ['new', 'read', 'replied', 'closed'];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->safeEmail(),
            'company' => $this->faker->optional(0.7)->company(),
            'phone' => $this->faker->optional(0.5)->phoneNumber(),
            'subject' => $this->faker->sentence(6, true),
            'message' => $this->faker->paragraphs(2, true),
            'inquiry_type' => $this->faker->randomElement($inquiryTypes),
            'status' => $this->faker->randomElement($statuses),
            'assigned_to' => $this->faker->optional(0.3)->randomElement(User::where('role', '!=', 'client')->pluck('id')->toArray()),
            'source_page' => $this->faker->optional(0.8)->randomElement([
                '/contact',
                '/services',
                '/portfolio',
                '/about',
                '/pricing'
            ]),
            'metadata' => [
                'user_agent' => $this->faker->userAgent(),
                'ip_address' => $this->faker->ipv4(),
                'referrer' => $this->faker->optional(0.6)->url(),
            ],
        ];
    }

    /**
     * Indicate that the inquiry is new.
     */
    public function statusNew(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'new',
        ]);
    }

    /**
     * Indicate that the inquiry is of a specific type.
     */
    public function type(string $type): static
    {
        return $this->state(fn (array $attributes) => [
            'inquiry_type' => $type,
        ]);
    }

    /**
     * Indicate that the inquiry is assigned to a specific user.
     */
    public function assignedTo(?int $userId): static
    {
        return $this->state(fn (array $attributes) => [
            'assigned_to' => $userId,
        ]);
    }
}
