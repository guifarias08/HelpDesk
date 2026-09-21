<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HelpDeskTest extends TestCase
{
    use RefreshDatabase;

    public function test_main_pages_are_available(): void
    {
        $this->get(route('dashboard'))->assertOk()->assertSee('Olá, Administrador');
        $this->get(route('tickets.index'))->assertOk()->assertSee('Fila de atendimento');
        $this->get(route('tickets.board'))->assertOk()->assertSee('Quadro de chamados');
        $this->get(route('categories.index'))->assertOk()->assertSee('Categorias cadastradas');
    }

    public function test_category_can_be_created_and_updated(): void
    {
        $this->post(route('categories.store'), ['name' => 'Infraestrutura', 'icon' => '🖥️'])
            ->assertSessionHas('success');

        $category = Category::firstOrFail();
        $this->put(route('categories.update', $category), ['name' => 'Hardware', 'icon' => '🔧'])
            ->assertSessionHas('success');

        $this->assertDatabaseHas('categories', ['name' => 'Hardware']);
    }

    public function test_ticket_can_be_created_and_filtered(): void
    {
        User::factory()->create();
        $category = Category::create(['name' => 'Rede', 'icon' => '🌐']);

        $response = $this->post(route('tickets.store'), [
            'title' => 'Sem acesso à internet',
            'description' => 'A estação não consegue acessar nenhum endereço.',
            'category_id' => $category->id,
            'priority' => 'high',
        ]);

        $ticket = Ticket::firstOrFail();
        $response->assertRedirect(route('tickets.show', $ticket));
        $this->get(route('tickets.index', ['priority' => 'high']))
            ->assertOk()
            ->assertSee('Sem acesso à internet');
    }
}
