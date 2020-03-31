<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use app\User;
use app\Message;
use DB;
use Carbon;
use Intervention\Image\Facades\Image;

class HomeController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function main()
    {
      // dd("Asdf");
      // $all_user = DB::table('users')->where('is_admin',0)->get()->count();
      $all_user=User::where('is_admin',0)->get()->count();
      $today_user=User::where('is_admin',0)->where('created_at',Carbon\Carbon::now())->get()->count();
      $online_user=User::where('status','Online')->get()->count();
      $message=DB::table('messages')->get()->count();
      // dd($message);
        return view('admin.home',compact('all_user','today_user','online_user','message'));
    }

    public function get_users(Request $request)
    {
      // dd(Carbon\Carbon::today()->addHours(1));

    $mhour_12am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today())->where('created_at','<=',Carbon\Carbon::today()->addHours(1))->get();
    $mhour_1am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(1))->where('created_at','<=',Carbon\Carbon::today()->addHours(2))->get()->count();
    $mhour_2am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(2))->where('created_at','<=',Carbon\Carbon::today()->addHours(3))->get()->count();
    $mhour_3am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(3))->where('created_at','<=',Carbon\Carbon::today()->addHours(4))->get()->count();
    $mhour_4am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(4))->where('created_at','<=',Carbon\Carbon::today()->addHours(5))->get()->count();
    $mhour_5am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(5))->where('created_at','<=',Carbon\Carbon::today()->addHours(6))->get()->count();
    $mhour_6am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(6))->where('created_at','<=',Carbon\Carbon::today()->addHours(7))->get()->count();
    $mhour_7am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(7))->where('created_at','<=',Carbon\Carbon::today()->addHours(8))->get()->count();
    $mhour_8am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(8))->where('created_at','<=',Carbon\Carbon::today()->addHours(9))->get()->count();
    $mhour_9am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(9))->where('created_at','<=',Carbon\Carbon::today()->addHours(10))->get()->count();
    $mhour_10am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(10))->where('created_at','<=',Carbon\Carbon::today()->addHours(11))->get()->count();
    $mhour_11am = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(11))->where('created_at','<=',Carbon\Carbon::today()->addHours(12))->get()->count();
    $mhour_12pm = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(12))->where('created_at','<=',Carbon\Carbon::today()->addHours(13))->get()->count();
    $mhour_1pm = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(13))->where('created_at','<=',Carbon\Carbon::today()->addHours(14))->get()->count();
    $mhour_2pm = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(14))->where('created_at','<=',Carbon\Carbon::today()->addHours(15))->get()->count();
    $mhour_3pm = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(15))->where('created_at','<=',Carbon\Carbon::today()->addHours(16))->get()->count();
    $mhour_4pm = User::where('gender','=',1)->where('created_at','>=',Carbon\Carbon::today()->addHours(16))->where('created_at','<=',Carbon\Carbon::today()->addHours(17))->get()->count();

    $fhour_12am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today())->where('created_at','<=',Carbon\Carbon::today()->addHours(1))->get();
    $fhour_1am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(1))->where('created_at','<=',Carbon\Carbon::today()->addHours(2))->get()->count();
    $fhour_2am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(2))->where('created_at','<=',Carbon\Carbon::today()->addHours(3))->get()->count();
    $fhour_3am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(3))->where('created_at','<=',Carbon\Carbon::today()->addHours(4))->get()->count();
    $fhour_4am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(4))->where('created_at','<=',Carbon\Carbon::today()->addHours(5))->get()->count();
    $fhour_5am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(5))->where('created_at','<=',Carbon\Carbon::today()->addHours(6))->get()->count();
    $fhour_6am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(6))->where('created_at','<=',Carbon\Carbon::today()->addHours(7))->get()->count();
    $fhour_7am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(7))->where('created_at','<=',Carbon\Carbon::today()->addHours(8))->get()->count();
    $fhour_8am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(8))->where('created_at','<=',Carbon\Carbon::today()->addHours(9))->get()->count();
    $fhour_9am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(9))->where('created_at','<=',Carbon\Carbon::today()->addHours(10))->get()->count();
    $fhour_10am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(10))->where('created_at','<=',Carbon\Carbon::today()->addHours(11))->get()->count();
    $fhour_11am = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(11))->where('created_at','<=',Carbon\Carbon::today()->addHours(12))->get()->count();
    $fhour_12pm = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(12))->where('created_at','<=',Carbon\Carbon::today()->addHours(13))->get()->count();
    $fhour_1pm = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(13))->where('created_at','<=',Carbon\Carbon::today()->addHours(14))->get()->count();
    $fhour_2pm = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(14))->where('created_at','<=',Carbon\Carbon::today()->addHours(15))->get()->count();
    $fhour_3pm = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(15))->where('created_at','<=',Carbon\Carbon::today()->addHours(16))->get()->count();
    $fhour_4pm = User::where('gender','=',2)->where('created_at','>=',Carbon\Carbon::today()->addHours(16))->where('created_at','<=',Carbon\Carbon::today()->addHours(17))->get()->count();

    // dd($hour_3pm);
    $obj = array(
      "mhour_12am" => $mhour_12am,
      "mhour_1am" => $mhour_1am,
      "mhour_2am" => $mhour_2am,
      "mhour_3am" => $mhour_3am,
      "mhour_4am" => $mhour_4am,
      "mhour_5am" => $mhour_5am,
      "mhour_6am" => $mhour_6am,
      "mhour_7am" => $mhour_7am,
      "mhour_8am" => $mhour_8am,
      "mhour_9am" => $mhour_9am,
      "mhour_10am" => $mhour_10am,
      "mhour_11am" => $mhour_11am,
      "mhour_12pm" => $mhour_12pm,
      "mhour_1pm" => $mhour_1pm,
      "mhour_2pm" => $mhour_2pm,
      "mhour_3pm" => $mhour_3pm,
      "mhour_4pm" => $mhour_4pm,

      "fhour_12am" => $fhour_12am,
      "fhour_1am" => $fhour_1am,
      "fhour_2am" => $fhour_2am,
      "fhour_3am" => $fhour_3am,
      "fhour_4am" => $fhour_4am,
      "fhour_5am" => $fhour_5am,
      "fhour_6am" => $fhour_6am,
      "fhour_7am" => $fhour_7am,
      "fhour_8am" => $fhour_8am,
      "fhour_9am" => $fhour_9am,
      "fhour_10am" => $fhour_10am,
      "fhour_11am" => $fhour_11am,
      "fhour_12pm" => $fhour_12pm,
      "fhour_1pm" => $fhour_1pm,
      "fhour_2pm" => $fhour_2pm,
      "fhour_3pm" => $fhour_3pm,
      "fhour_4pm" => $fhour_4pm
    );
    echo json_encode($obj);
  }

    public function get_users_weekly(Request $request)
    {
      $agoDate = Carbon\Carbon::now()->subWeek();
      $mweekly_data = User::where('gender','=',1)->where('created_at','>=',$agoDate)->where('created_at','<=',Carbon\Carbon::today())->get();
      foreach ($mweekly_data as &$data) {
        $data->day=Carbon\Carbon::parse($data->created_at)->format('l');
      }
      $mMonday = $mweekly_data->where("day",'Monday')->count();
      $mTuesday = $mweekly_data->where("day",'Tuesday')->count();
      $mWednesday = $mweekly_data->where("day",'Wednesday')->count();
      $mThursday = $mweekly_data->where("day",'Thursday')->count();
      $mFriday = $mweekly_data->where("day",'Friday')->count();
      $mSaturday = $mweekly_data->where("day",'Saturday')->count();
      $mSunday = $mweekly_data->where("day",'Sunday')->count();

      $fweekly_data = User::where('gender','=',2)->where('created_at','>=',$agoDate)->where('created_at','<=',Carbon\Carbon::today())->get();
      foreach ($fweekly_data as &$data) {
        $data->day=Carbon\Carbon::parse($data->created_at)->format('l');
      }
      $fMonday = $fweekly_data->where("day",'Monday')->count();
      $fTuesday = $fweekly_data->where("day",'Tuesday')->count();
      $fWednesday = $fweekly_data->where("day",'Wednesday')->count();
      $fThursday = $fweekly_data->where("day",'Thursday')->count();
      $fFriday = $fweekly_data->where("day",'Friday')->count();
      $fSaturday = $fweekly_data->where("day",'Saturday')->count();
      $fSunday = $fweekly_data->where("day",'Sunday')->count();
      // dd($mMonday,$mTuesday,$mWednesday,$mThursday,$mFriday,$mSaturday,$mSunday);
    $obj = array(
      "mMonday" => $mMonday,
      "mTuesday" => $mTuesday,
      "mWednesday" => $mWednesday,
      "mThursday" => $mThursday,
      "mFriday" => $mFriday,
      "mSaturday" => $mSaturday,
      "mSunday" => $mSunday,

      "fMonday" => $fMonday,
      "fTuesday" => $fTuesday,
      "fWednesday" => $fWednesday,
      "fThursday" => $fThursday,
      "fFriday" => $fFriday,
      "fSaturday" => $fSaturday,
      "fSunday" => $fSunday
    );
    echo json_encode($obj);
  }

    public function get_users_monthly(Request $request)
    {
      $agoDate = Carbon\Carbon::now()->subYear();
      // dd(Carbon\Carbon::now()->format('F'));
      $mmonthly_data = User::where('gender','=',1)->where('created_at','>=',$agoDate)->where('created_at','<=',Carbon\Carbon::today())->get();
      foreach ($mmonthly_data as &$data) {
        $data->month=Carbon\Carbon::parse($data->created_at)->format('F');
      }
      // dd($mmonthly_data);
      $mJanuary = $mmonthly_data->where("month",'January')->count();
      $mFebruary = $mmonthly_data->where("month",'February')->count();
      $mMarch = $mmonthly_data->where("month",'March')->count();
      $mApril = $mmonthly_data->where("month",'April')->count();
      $mMay = $mmonthly_data->where("month",'May')->count();
      $mJune = $mmonthly_data->where("month",'June')->count();
      $mJuly = $mmonthly_data->where("month",'July')->count();
      $mAugust = $mmonthly_data->where("month",'August')->count();
      $mSeptember = $mmonthly_data->where("month",'September')->count();
      $mOctober = $mmonthly_data->where("month",'October')->count();
      $mNovember = $mmonthly_data->where("month",'November')->count();
      $mDecember = $mmonthly_data->where("month",'December')->count();

      $fmonthly_data = User::where('gender','=',2)->where('created_at','>=',$agoDate)->where('created_at','<=',Carbon\Carbon::today())->get();
      foreach ($fmonthly_data as &$data) {
        $data->month=Carbon\Carbon::parse($data->created_at)->format('F');
      }
      // dd($fmonthly_data);
      $fJanuary = $fmonthly_data->where("month",'January')->count();
      $fFebruary = $fmonthly_data->where("month",'February')->count();
      $fMarch = $fmonthly_data->where("month",'March')->count();
      $fApril = $fmonthly_data->where("month",'April')->count();
      $fMay = $fmonthly_data->where("month",'May')->count();
      $fJune = $fmonthly_data->where("month",'June')->count();
      $fJuly = $fmonthly_data->where("month",'July')->count();
      $fAugust = $fmonthly_data->where("month",'August')->count();
      $fSeptember = $fmonthly_data->where("month",'September')->count();
      $fOctober = $fmonthly_data->where("month",'October')->count();
      $fNovember = $fmonthly_data->where("month",'November')->count();
      $fDecember = $fmonthly_data->where("month",'December')->count();
      // dd($mMonday,$mTuesday,$mWednesday,$mThursday,$mFriday,$mSaturday,$mSunday);
    $obj = array(
      "mJanuary" => $mJanuary,
      "mFebruary" => $mFebruary,
      "mMarch" => $mMarch,
      "mApril" => $mApril,
      "mMay" => $mMay,
      "mJune" => $mJune,
      "mJuly" => $mJuly,
      "mAugust" => $mAugust,
      "mSeptember" => $mSeptember,
      "mOctober" => $mOctober,
      "mNovember" => $mNovember,
      "mDecember" => $mDecember,

      "fJanuary" => $fJanuary,
      "fFebruary" => $fFebruary,
      "fMarch" => $fMarch,
      "fApril" => $fApril,
      "fMay" => $fMay,
      "fJune" => $fJune,
      "fJuly" => $fJuly,
      "fAugust" => $fAugust,
      "fSeptember" => $fSeptember,
      "fOctober" => $fOctober,
      "fNovember" => $fNovember,
      "fDecember" => $fDecember
    );
    echo json_encode($obj);
    }

    public function pages()
    {
        $pages = Page::all();
        return view('admin.page.pages',compact('pages'));
    }

    public function addPage()
    {
        return view('admin.page.add-page');
    }

    public function submitPage(Request $request)
    {
        $fileName = $this->uploadImage($request);
        $rules = array(
          'title' => 'required',
          'content' => 'required'
        );
        $validator = Validator::make($this->request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors((array)$validator->errors());
        }

        $page = new Page();
        $page->title = $request->title;
        $page->slug = Str::slug($page->title);
        $page->content = $request->content;
        $page->keywords = $request->keywords;
        $page->image = $fileName;
        $page->description = $request->description;
        $page->save();
        return redirect()->route('adminpages');
    }

    public function uploadImage($request)
    {
        if ($request->hasFile('image')) {
            $picture = $request->file('image');
            $images = Image::make($picture);
            $fileName = pathinfo('_page_' . '_' . rand(), PATHINFO_FILENAME) . '.' . $picture->getClientOriginalExtension();
            $images->save('uploads/' . $fileName);
            return $fileName;
        }
    }

    public function editPage($id)
    {
      $edit  = Page::where('id', $id)->first();
        return view('admin.page.edit-page', compact('edit'));
    }


    public function updatePage(Request $request, $id)
    {
        $fileName = $this->updateImage($request, $id);
        $rules = array(
          'title' => 'required',
          'content' => 'required'
        );
        $validator = Validator::make($this->request->all(), $rules);
        if($validator->fails()){
            return redirect()->back()->withErrors((array)$validator->errors());
        }

        $page = Page::find($id);
        $page->title = $request->title;
        $page->slug = Str::slug($page->title);
        $page->content = $request->content;
        $page->keywords = $request->keywords;
        $page->image = $fileName;
        $page->description = $request->description;
        $page->save();
        return redirect()->route('adminpages');
    }
       public function updateImage($request, $id)
    {
        $img = Page::where('id', $id)->first();
        if ($request->hasFile('image')) {
            $file_path = $img->image;
            if($img->image){
              $storage_path = 'uploads/' . $file_path;
              if (\File::exists($storage_path)) {
                  unlink($storage_path);
              }
            }

            $picture = $request->file('image');
            $images = Image::make($picture);
            $picture = $request->file('image');
            $fileName = pathinfo('_logo_' . '_' . rand(), PATHINFO_FILENAME) . '.' . $picture->getClientOriginalExtension();
            $images->save('uploads/' . $fileName);
        } else {
            $fileName = $img['image'];
        }
        return $fileName;
    }

    public function deletePage($id)
    {
        $page = false;
        if($id){
            $page = Page::where('id', $id)->first();
            if($page){
                $page->delete();
            }
        }
        return redirect()->back();
    }
}