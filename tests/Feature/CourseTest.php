<?php

test('example', function () {
     $user = User::factory()->create();

    $response = $this->actingAs($user)
                     ->get('/courses');

    $response->assertStatus(200);
    $response->assertSee('Available Courses');
});
