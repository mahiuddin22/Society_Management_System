@extends('admin.layouts.app')

@section('content')

<div class="card">

    <div class="card-head">
        <h3>Saved Drafts</h3>

        <button class="btn btn-primary btn-sm">
            + New Draft
        </button>
    </div>

    <div class="table-wrap">

        <table class="ledger text-nowrap">

            <thead>
                <tr>
                    <th>Type</th>
                    <th>Message</th>
                    <th>Language</th>
                    <th>Length</th>
                    <th>Saved</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td><span class="badge badge-paid">Invoice</span></td>
                    <td>Monthly Invoice Notice</td>
                    <td>বাংলা</td>
                    <td>112 chars · 2 SMS</td>
                    <td>2 days ago</td>
                    <td>
                        <button class="btn btn-secondary btn-sm">Edit</button>
                        <button class="btn btn-primary btn-sm">Use</button>
                    </td>
                </tr>

                <tr>
                    <td><span class="badge badge-partial">Reminder</span></td>
                    <td>Payment Reminder — Due</td>
                    <td>English</td>
                    <td>148 chars · 1 SMS</td>
                    <td>5 days ago</td>
                    <td>
                        <button class="btn btn-secondary btn-sm">Edit</button>
                        <button class="btn btn-primary btn-sm">Use</button>
                    </td>
                </tr>

                <tr>
                    <td><span class="badge badge-neutral">Invitation</span></td>
                    <td>Cultural Program Invitation</td>
                    <td>বাংলা</td>
                    <td>205 chars · 4 SMS</td>
                    <td>1 week ago</td>
                    <td>
                        <button class="btn btn-secondary btn-sm">Edit</button>
                        <button class="btn btn-primary btn-sm">Use</button>
                    </td>
                </tr>

                <tr>
                    <td><span class="badge badge-neutral">Invitation</span></td>
                    <td>Medical Camp Announcement</td>
                    <td>English</td>
                    <td>165 chars · 2 SMS</td>
                    <td>2 weeks ago</td>
                    <td>
                        <button class="btn btn-secondary btn-sm">Edit</button>
                        <button class="btn btn-primary btn-sm">Use</button>
                    </td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

@endsection