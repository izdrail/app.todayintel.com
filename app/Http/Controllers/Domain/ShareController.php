<?php
declare(strict_types=1);
namespace App\Http\Controllers\Domain;
use App\Data\Models\Article;
use App\Features\GeneratorFeature;
use Filament\Notifications\Notification;
use Illuminate\Http\RedirectResponse;
use Lucid\Bus\ServesFeatures;
use Lucid\Units\Controller;

class ShareController extends Controller
{
    use ServesFeatures;

    final function generate(Article $article): RedirectResponse
    {

        $response =  $this->serve(GeneratorFeature::class, [
            'article' => $article,
        ]);

        $response->handle();

        Notification::make()
            ->title("Content sent to AI for generation")
            ->success()
            ->send();

        return redirect()->back(302, ['message' => 'Content Generated']);
    }
}

