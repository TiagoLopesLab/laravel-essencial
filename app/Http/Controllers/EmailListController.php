<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use RuntimeException;
use Throwable;

class EmailListController extends Controller
{
    public function index(): View
    {
        return view('email-list.index', [
            'emailLists' => EmailList::query()->paginate()
        ]);
    }

    public function create(): View
    {
        return view('email-list.create');
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'file' => ['required', 'file', 'mimes:csv']
        ]);

        /** @var UploadedFile $file */
        $file = $request->file('file');
        $emails = $this->getEmailsFromCsvFile($file->getRealPath());

        DB::transaction(function () use ($data, $emails) {
            $emailList = EmailList::query()->create([
                'title' => $data['title']
            ]);

            $emailList->subscribers()->createMany($emails);
        });

        return to_route('email-list.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmailList $list)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmailList $list)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmailList $list)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmailList $list)
    {
        //
    }

    private function getEmailsFromCsvFile(string $filename): array
    {
        $fileHandle = fopen(filename: $filename, mode: 'r');
        if ($fileHandle === false) {
            throw new RuntimeException('Erro na leitura do CSV');
        }

        $items = [];

        while (($row = fgetcsv($fileHandle)) !== false) {
            if ($row[0] === 'Name' && $row[1] === 'Email') {
                continue;
            }

            $items[] = [
                'name' => $row[0],
                'email' => $row[1]
            ];
        }

        return $items;
    }
}
