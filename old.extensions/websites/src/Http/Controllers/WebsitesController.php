<?php

namespace Cornatul\Websites\Http\Controllers;

use Cornatul\Websites\Http\Requests\CreateWebsiteRequest;
use Cornatul\Websites\Repositories\WebsiteRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class WebsitesController
{
    public function __construct(private readonly WebsiteRepositoryInterface $websitesRepository)
    {
    }

    final public function index(): View
    {
        return view('websites::index');
    }

    final public function create(): View
    {
        return view('websites::create');
    }

    final public function store(CreateWebsiteRequest $request): RedirectResponse
    {
        $this->websitesRepository->create($request);
        return redirect()->route('waterhole.cp.websites.index')
            ->with('success', __('Website created'));
    }
}
