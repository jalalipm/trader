<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\UserDocument;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function anyData()
    {
        return datatables()->of(User::User()->get())
            ->addColumn('action', function ($user) {
                return view('admin.users.operations', compact('user'));
            })->make(true);
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $user_data = [
            'first_name' => request()->input('first_name'),
            'last_name' => request()->input('last_name'),
            'name' => request()->input('first_name') . ' ' . request()->input('last_name'),
            'cell_phone' => request()->input('cell_phone'),
            'email' => request()->input('email'),
            'password' => bcrypt(request()->input('password')),
            'national_code' => request()->input('national_code'),
            'address' => request()->input('address'),
            'postal_code' => request()->input('postal_code'),
        ];

        $new_user = User::create($user_data);
        if ($new_user instanceof User) {

            try {
                if (Request()->hasFile('f_national')) {
                    $user_document = [
                        'user_id' => $new_user->id,
                        'status' => request()->input('status_f_national'),
                        'kind' => 1,
                        'comment' => request()->input('comment_f_national'),
                    ];
                    $new_name = $new_user->first_name . '_' . $new_user->last_name . '_' . str_random(8) . '_' . request()->file('f_national')->getClientOriginalName();
                    $result_proposal_file = request()->file('f_national')->move(public_path('files/user_document'), $new_name);
                    if ($result_proposal_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                    UserDocument::create($user_document);
                }
                if (Request()->hasFile('b_national')) {
                    $user_document = [
                        'user_id' => $new_user->id,
                        'status' => request()->input('status_b_national'),
                        'kind' => 2,
                        'comment' => request()->input('comment_b_national'),
                    ];
                    $new_name = $new_user->first_name . '_' . $new_user->last_name . '_' . str_random(8) . '_' . request()->file('b_national')->getClientOriginalName();
                    $result_proposal_file = request()->file('b_national')->move(public_path('files/user_document'), $new_name);
                    if ($result_proposal_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                    UserDocument::create($user_document);
                }
                if (Request()->hasFile('f_birth_certificate')) {
                    $user_document = [
                        'user_id' => $new_user->id,
                        'status' => request()->input('status_f_birth_certificate'),
                        'kind' => 3,
                        'comment' => request()->input('comment_f_birth_certificate'),
                    ];
                    $new_name = $new_user->first_name . '_' . $new_user->last_name . '_' . str_random(8) . '_' . request()->file('f_birth_certificate')->getClientOriginalName();
                    $result_proposal_file = request()->file('f_birth_certificate')->move(public_path('files/user_document'), $new_name);
                    if ($result_proposal_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                    UserDocument::create($user_document);
                }
                if (Request()->hasFile('c_birth_certificate')) {
                    $user_document = [
                        'user_id' => $new_user->id,
                        'status' => request()->input('status_c_birth_certificate'),
                        'kind' => 4,
                        'comment' => request()->input('comment_c_birth_certificate'),
                    ];
                    $new_name = $new_user->first_name . '_' . $new_user->last_name . '_' . str_random(8) . '_' . request()->file('c_birth_certificate')->getClientOriginalName();
                    $result_proposal_file = request()->file('c_birth_certificate')->move(public_path('files/user_document'), $new_name);
                    if ($result_proposal_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                    UserDocument::create($user_document);
                }
            } catch (Exception $e) {
                return response('document_upload_error', 400);
            }
            // return response('create', 200);
            return response(route('admin.users.list'), 200);
        }
        return response(false, 400);
    }

    public function edit($id)
    {
        if ($id && ctype_digit($id)) {
            $user = User::find($id);
            $user_document = UserDocument::where('user_id', $id)->get();
            $user_f_national = $user_document->where('kind', 1)->first() != null ? $user_document->where('kind', 1)->first() : null;
            $user_b_national = $user_document->where('kind', 2)->first() != null ? $user_document->where('kind', 2)->first() : null;
            $user_f_birth_certificate = $user_document->where('kind', 3)->first() != null ? $user_document->where('kind', 3)->first() : null;
            $user_c_birth_certificate = $user_document->where('kind', 4)->first() != null ? $user_document->where('kind', 4)->first() : null;
            // dd($user_b_national->status, $user_b_national->status == 'approved');
            if ($user && $user instanceof User) {
                return view(
                    'admin.users.create',
                    compact(
                        'user',
                        'user_f_national',
                        'user_b_national',
                        'user_f_birth_certificate',
                        'user_c_birth_certificate'
                    )
                );
            }
        }
    }

    public function update(Request $request)
    {
        $input = request()->except('_token');
        $user_item = User::find($request->id);
        $user_document = UserDocument::where('user_id', $request->id)->get();
        $user_f_national = $user_document->where('kind', 1)->first() != null ? $user_document->where('kind', 1)->first() : null;
        $user_b_national = $user_document->where('kind', 2)->first() != null ? $user_document->where('kind', 2)->first() : null;
        $user_f_birth_certificate = $user_document->where('kind', 3)->first() != null ? $user_document->where('kind', 3)->first() : null;
        $user_c_birth_certificate = $user_document->where('kind', 4)->first() != null ? $user_document->where('kind', 4)->first() : null;

        if (
            Request()->hasFile('f_national') ||
            Request()->hasFile('b_national') ||
            Request()->hasFile('f_birth_certificate') ||
            Request()->hasFile('c_birth_certificate')
        ) {

            try {
                $input = request()->except('_token');
                $base_url = URL::to('/');
                /**************************** f_national *************************** */
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_f_national'),
                    'kind' => 1,
                    'comment' => request()->input('comment_f_national'),
                ];
                if (Request()->hasFile('f_national')) {
                    $new_name = $request->first_name . '_' . $request->last_name . '_' . str_random(8) . '_' . request()->file('f_national')->getClientOriginalName();
                    $result_f_national_file = request()->file('f_national')->move(public_path('files/user_document'), $new_name);
                    if ($result_f_national_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document_input['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                }
                if (isset($user_f_national)) {
                    if (Request()->hasFile('f_national')) {
                        $file_name = public_path() . substr($user_f_national->pic_path, strlen($base_url));
                        if (file_exists($file_name))
                            try {
                                unlink($file_name);
                            } catch (\Exception $e) {
                            }
                    }
                    $user_f_national->update($user_document_input);
                    // $user_f_national->delete();
                } else if (Request()->hasFile('f_national')) {
                    UserDocument::create($user_document_input);
                }
                /**************************** b_national *************************** */
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_b_national'),
                    'kind' => 2,
                    'comment' => request()->input('comment_b_national'),
                ];
                if (Request()->hasFile('b_national')) {
                    $new_name = $request->first_name . '_' . $request->last_name . '_' . str_random(8) . '_' . request()->file('b_national')->getClientOriginalName();
                    $result_b_national_file = request()->file('b_national')->move(public_path('files/user_document'), $new_name);
                    if ($result_b_national_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document_input['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                }
                if (isset($user_b_national)) {
                    if (Request()->hasFile('b_national')) {
                        $file_name = public_path() . substr($user_b_national->pic_path, strlen($base_url));
                        if (file_exists($file_name))
                            try {
                                unlink($file_name);
                            } catch (\Exception $e) {
                            }
                    }
                    $user_b_national->update($user_document_input);
                    // $user_b_national->delete();
                } else if (Request()->hasFile('b_national')) {
                    UserDocument::create($user_document_input);
                }
                /**************************** f_birth_certificate *************************** */
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_f_birth_certificate'),
                    'kind' => 3,
                    'comment' => request()->input('comment_f_birth_certificate'),
                ];
                if (Request()->hasFile('f_birth_certificate')) {
                    $new_name = $request->first_name . '_' . $request->last_name . '_' . str_random(8) . '_' . request()->file('f_birth_certificate')->getClientOriginalName();
                    $result_f_birth_certificate_file = request()->file('f_birth_certificate')->move(public_path('files/user_document'), $new_name);
                    if ($result_f_birth_certificate_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document_input['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                }
                if (isset($user_f_birth_certificate)) {
                    if (Request()->hasFile('f_birth_certificate')) {
                        $file_name = public_path() . substr($user_f_birth_certificate->pic_path, strlen($base_url));
                        if (file_exists($file_name))
                            try {
                                unlink($file_name);
                            } catch (\Exception $e) {
                            }
                    }
                    $user_f_birth_certificate->update($user_document_input);
                    // $user_f_birth_certificate->delete();
                } else if (Request()->hasFile('f_birth_certificate')) {
                    UserDocument::create($user_document_input);
                }
                /**************************** c_birth_certificate *************************** */
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_c_birth_certificate'),
                    'kind' => 4,
                    'comment' => request()->input('comment_c_birth_certificate'),
                ];
                if (Request()->hasFile('c_birth_certificate')) {
                    $new_name = $request->first_name . '_' . $request->last_name . '_' . str_random(8) . '_' . request()->file('c_birth_certificate')->getClientOriginalName();
                    $result_c_birth_certificate_file = request()->file('c_birth_certificate')->move(public_path('files/user_document'), $new_name);
                    if ($result_c_birth_certificate_file instanceof \Symfony\Component\HttpFoundation\File\File) {
                        $user_document_input['pic_path'] = url("/files/user_document/{$new_name}");
                    }
                }
                if (isset($user_c_birth_certificate)) {
                    if (Request()->hasFile('c_birth_certificate')) {
                        $file_name = public_path() . substr($user_c_birth_certificate->pic_path, strlen($base_url));
                        if (file_exists($file_name))
                            try {
                                unlink($file_name);
                            } catch (\Exception $e) {
                            }
                    }
                    $user_c_birth_certificate->update($user_document_input);
                    // $user_c_birth_certificate->delete();
                } else if (Request()->hasFile('c_birth_certificate')) {
                    UserDocument::create($user_document_input);
                }
            } catch (Exception $e) {
                // dd($e);
                return response('document_upload_error', 400);
            }
            if (empty(request()->input('password'))) {
                unset($input['password']);
            } else {
                $input['password'] = bcrypt($input['password']);
            }
            $input['name'] = request()->input('first_name') . ' ' . request()->input('last_name');
            $user_item->update($input);
            return response(route('admin.users.list'), 200);
        } else {
            $input = request()->except('_token');

            if (empty(request()->input('password'))) {
                unset($input['password']);
            } else {
                $input['password'] = bcrypt($input['password']);
            }
            $input['name'] = request()->input('first_name') . ' ' . request()->input('last_name');
            $user_item->update($input);

            if (isset($user_f_national)) {
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_f_national'),
                    'kind' => 1,
                    'comment' => request()->input('comment_f_national'),
                ];
                $user_f_national->update($user_document_input);
            }
            if (isset($user_b_national)) {
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_b_national'),
                    'kind' => 2,
                    'comment' => request()->input('comment_b_national'),
                ];
                $user_b_national->update($user_document_input);
            }
            if (isset($user_f_birth_certificate)) {
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_f_birth_certificate'),
                    'kind' => 3,
                    'comment' => request()->input('comment_f_birth_certificate'),
                ];
                $user_f_birth_certificate->update($user_document_input);
            }
            if (isset($user_c_birth_certificate)) {
                $user_document_input = [
                    'user_id' => $user_item->id,
                    'status' => request()->input('status_c_birth_certificate'),
                    'kind' => 4,
                    'comment' => request()->input('comment_c_birth_certificate'),
                ];
                $user_c_birth_certificate->update($user_document_input);
            }

            return response(route('admin.users.list', request()->input('center_id')), 200);
        }
    }

    public function destroy($id)
    {
        if ($id && ctype_digit($id)) {
            $user = User::find($id);
            if ($user && $user instanceof User) {
                $user->delete();
                return redirect()->route('admin.users.list');
            }
        }
    }


    public function push_update(Request $request)
    {
        //        dd($push_id.' -- '.$id);
        $user_item = User::find($request->id);
        $input = [
            'push_id' => $request->push_id,
        ];
        $user_item->update($input);
        return response('ok', 200);
    }

    // public function online_support($user_id)
    // {
    //     try {
    //         // dd($user_id);
    //         $chats = SupportMessageModel::SupportMessageByUserID($user_id)->get()->toArray();
    //         $user = User::find($user_id);
    //         $chat_days = SupportMessageModel::whereRaw("ifnull(support_message.receiver_id,0) = '$user_id'")
    //             ->orWhere('support_message.sender_id', $user_id)
    //             ->select(
    //                 DB::raw("cast(support_message.created_at as date) as created_at"),
    //                 DB::raw('count(*) as total')
    //             )->groupBy(DB::raw("cast(support_message.created_at as date)"))->get();
    //         for ($i = 0; $i < count($chat_days); $i++) {
    //             $data = [
    //                 'id' => 0,
    //                 'comment' => '',
    //                 'sender_id' => 0,
    //                 'sender' => '',
    //                 'sender_avatar' => '',
    //                 'receiver_id' => 0,
    //                 'receiver' => '',
    //                 'file_path' => '',
    //                 'file_type' => '',
    //                 'view_type' => 3,
    //                 'created_at' => ($chat_days[$i]['created_at'])->format('Y-m-d H:i:s'), //Carbon::parse($date_time)->format('Y-m-d h:i:s'),
    //                 'shamsi_created_date' => verta($chat_days[$i]['created_at'])->format('Y-m-d'),
    //                 'created_time' => '',
    //             ];
    //             array_push($chats, $data);
    //         }
    //         $chats = collect($chats)->sortBy('created_at');
    //         return view('admin.users.online_supports.index', compact('user', 'chats'));
    //     } catch (\Exception $e) {
    //         // dd($e);
    //     }
    // }

    // public function store_online_support(Request $request)
    // {
    //     $data = [
    //         'comment' => request()->input('comment'),
    //         'sender_id' => request()->input('sender_id'),
    //         'receiver_id' => request()->input('receiver_id'),
    //         'created_at' => Carbon::now(new \DateTimeZone('Asia/Tehran')),
    //         'updated_at' => Carbon::now(new \DateTimeZone('Asia/Tehran')),
    //     ];
    //     $new_message = SupportMessageModel::create($data);
    //     // dd($new_message);
    //     $receiver = User::find(request()->input('receiver_id'));
    //     $json_data = SupportMessageModel::SupportMessage()->find($new_message->id);
    //     $data = [
    //         'imei' => $receiver->push_id,
    //         'title' => 'پشتیبانی آنلاین',
    //         'content' => request()->input('comment'),
    //         'item_id' => $new_message->id,
    //         'type' => 'support_message',
    //         'json_data' => [
    //             'comment' => $json_data->comment,
    //             'sender_id' => $json_data->sender_id,
    //             'sender' => $json_data->sender,
    //             'receiver_id' => $json_data->receiver_id,
    //             'file_path' => $json_data->file_path,
    //             'file_type' => $json_data->file_type,
    //             'view_type' => $json_data->view_type,
    //             'created_at' => $json_data->created_at->format('Y-m-d H:i:s'),
    //             'shamsi_created_date' => $json_data->shamsi_created_date,
    //             'created_time' => $json_data->created_time,
    //         ]
    //     ];
    //     event(new SendNotification($data));
    //     if ($new_message instanceof SupportMessageModel) {
    //         return response('create', 200);
    //     }
    //     return response(false, 400);
    // }

    // public function read_message(Request $request)
    // {
    //     $user_item = SupportMessageModel::where(function ($query) use ($request) {
    //         $query->where('receiver_id', $request->receiver_id)->orWhere('sender_id', $request->receiver_id);
    //     })->where('is_read', 0);
    //     $user_item->update(['is_read' => 1]);
    //     return response('update', 200);
    // }

    // public function unread_messages()
    // {
    //     $unread_messages = SupportMessageModel::UnReadMessage()->get();
    //     return response(['data' => $unread_messages], 200);
    // }
}
