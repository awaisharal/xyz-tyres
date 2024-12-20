<?php

namespace App\Http\Controllers\Shopkeeper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Template;

class TemplateController extends Controller
{
    public function index()
    {
        $templates = Template::where('user_id', auth()->id())->get();
        return view('shopkeeper.profile.edit', compact('templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        Template::create([
            'user_id' => auth()->id(),
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return redirect()->back()->with('success', 'Template added successfully!');
    }

    public function update(Request $request, Template $template)
    {
        $this->authorizeTemplate($template);

        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
        ]);

        $template->update($request->only('key', 'value'));

        return redirect()->back()->with('success', 'Template updated successfully!');
    }

    public function destroy(Template $template)
    {
        $this->authorizeTemplate($template);

        $template->delete();

        return redirect()->back()->with('success', 'Template deleted successfully!');
    }

    private function authorizeTemplate(Template $template)
    {
        if ($template->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
