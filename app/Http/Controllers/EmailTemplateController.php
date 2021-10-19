<?php

namespace App\Http\Controllers;

use App\EmailTemplate;
use Illuminate\Http\Request;

class EmailTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @returnq \Illuminate\Http\Response
     */
    public function index()
    {
        $emailTemplates = EmailTemplate::all();
        return view('admin.email-templates')
            ->with('type', 'view')
            ->with('active', 'email-templates')
            ->with('emailTemplates', $emailTemplates);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.email-templates')
            ->with('type', 'create')
            ->with('active', 'email-templates');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required',
            'emailSubject'      => 'required',
            'emailBody'      => 'required'
        ]);
        $e = new EmailTemplate;
        $e->name = $r->name;
        $e->emailSubject = $r->emailSubject;
        $e->senderName = $r->senderName;
        $e->sentFrom = $r->sentFrom;
        $e->emailBody = $r->emailBody;
        $e->status = $r->status;
        $e->save();
        return redirect('admin/email-templates')->with('msg', 'Email template successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\EmailTemplate  $e
     * @return \Illuminate\Http\Response
     */
    public function show(EmailTemplate $emailTemplate)
    {
        //$templateData = EmailTemplate::find($emailTemplate);
        return view('admin.email-templates')
            ->with('type', 'edit')
            ->with('templateData', $emailTemplate)
            ->with('active', 'email-templates');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\EmailTemplate  $e
     * @return \Illuminate\Http\Response
     */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email-templates')
            ->with('type', 'edit')
            ->with('templateData', $emailTemplate)
            ->with('active', 'email-templates');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $r, EmailTemplate $emailTemplate)
    {
        $this->validate($r, [
            'name' => 'required',
            'emailSubject'      => 'required',
            'emailBody'      => 'required'
        ]);
        $emailTemplate->name = $r->name;
        $emailTemplate->emailSubject = $r->emailSubject;
        $emailTemplate->senderName = $r->senderName;
        $emailTemplate->sentFrom = $r->sentFrom;
        $emailTemplate->emailBody = $r->emailBody;
        $emailTemplate->status = $r->status;
        $emailTemplate->save();
        return redirect('admin/email-templates')->with('msg', 'Email template successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\EmailTemplate  $emailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();
        return redirect('admin/email-templates')->with('msg', 'Email template successfully deleted.');
    }
}
