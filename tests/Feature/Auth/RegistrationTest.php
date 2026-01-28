<?php

test('registration screen can be rendered', function () {
    $response = $this->get(route('register'));

    $response->assertStatus(200);
});

// test('new users can register', function () {
//     $response = $this->post(route('register.store'), [
//         'name' => 'Test User',
//         'email' => 'test@example.com',
//         'password' => 'secret',
//         'password_confirmation' => 'secret',
//     ]);

//     $this->assertAuthenticated();
//     $response->assertRedirect(route('authed', absolute: false));
// });
