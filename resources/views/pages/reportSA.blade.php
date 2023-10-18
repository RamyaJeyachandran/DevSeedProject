@extends('layouts.main')
@section('title','Consent Form')
@section ('style')
<link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />

@endsection 
@section('content')
    @include('layouts.mobileSideMenu')
    <div class="flex mt-[4.7rem] md:mt-0">
        @include('layouts.sideMenu')
                <!-- BEGIN: Content -->
                <div class="content">
                    @include('layouts.topBar')<p>SEMEN ANALYSIS REPORT</p>
<table style="width: 608px;" border="1" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top" width="60">
<p>Name</p>
</td>
<td valign="top" width="59">
<p>Xxx</p>
</td>
<td valign="top" width="61">
<p>Patient #</p>
</td>
<td valign="top" width="59">
<p>Xxx</p>
</td>
<td valign="top" width="70">
<p>Dob/AGE</p>
</td>
<td valign="top" width="59">
<p>Xx</p>
</td>
<td valign="top" width="61">
<p>Gender</p>
</td>
<td valign="top" width="60">
<p>Xxxx</p>
</td>
<td valign="top" width="60">
<p>Date</p>
</td>
<td valign="top" width="59">
<p>xx-xx-xxx</p>
</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
<table border="1" cellspacing="0" cellpadding="0">
<tbody>
<tr>
<td valign="top" width="264">
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p>Result</p>
</td>
<td valign="top" width="164">
<p>Normal Range</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p><strong>Add spouse name</strong></p>
</td>
<td valign="top" width="174">
<p>&nbsp;</p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td colspan="3" valign="top" width="601">
<p>PHYSICAL EXAMINATION</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>LIQUEFACTION</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p>30 min</p>
<p>45 min</p>
<p>60 min</p>
<p>Not liquified</p>
<p>Not applicable</p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>APPEARANCE</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p>Pale Yellow</p>
<p>Grey</p>
<p>Whitish</p>
<p>Dark Brown</p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>PH</p>
</td>
<td valign="top" width="174">
<p><em>DROP DOWN</em></p>
<p>6.5 TO 9.0</p>
</td>
<td valign="top" width="164">
<p>Normal Value: 7.2-7.8</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>VOLUME / SPILL</p>
</td>
<td valign="top" width="174">
<p><em>TEXT BOX (ml)</em></p>
</td>
<td valign="top" width="164">
<p>more than 1.5 ml</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>VISCOSITY</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p>Normal</p>
<p>Viscous</p>
<p>Semi viscous</p>
<p>Not applicable</p>
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>ABSTINENCE</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p><em>1 Day</em></p>
<p><em>2 Day</em></p>
<p><em>3 Day</em></p>
<p><em>4 Day</em></p>
<p><em>5 Day</em></p>
<p><em>6 Day</em></p>
<p><em>7 Day</em></p>
<p><em>More than 7 days</em></p>
<p><em>&nbsp;</em></p>
<p><em>&nbsp;</em></p>
<p><em>&nbsp;</em></p>
<p><em>&nbsp;</em></p>
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>Medication</p>
</td>
<td valign="top" width="174">
<p><em>Text box</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td colspan="3" valign="top" width="601">
<p>MICROSCOPIC EXAMINATION</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>SPERM CONCENTRATION</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text box (mil/ml)</em></p>
</td>
<td valign="top" width="164">
<p>more than 15.0 mil/ml</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>AGGLUTINATION</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p>Present</p>
<p>Absent</p>
<p>Nil</p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>CLUMPING</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p>Present</p>
<p>Absent</p>
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>GRANULAR DEBRIS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Drop Down</em></p>
<p>Present</p>
<p>Absent</p>
<p>Nil</p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td colspan="3" valign="top" width="601">
<table style="width: 1140px;" border="1" cellspacing="3" cellpadding="0">
<tbody>
<tr>
<td colspan="3" valign="top">
<p>SPERM MOTILITY</p>
</td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>
</tbody>
</table>
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>TOTAL MOTILITY</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>RAPID PROGRESSIVE MOVEMENT</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>SLUGGISH PROGRESSIVE MOVEMENT</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>NON PROGRESSIVE</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>NON MOTILE</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td colspan="3" valign="top" width="601">
<p>SPERM MORPHOLOGY</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>NORMAL SPERMS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>HEAD DEFECTS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>NECK AND MID PIECE DEFECTS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>TAIL DEFECTS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>CYTOPLASMIC DROPLETS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (%)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td colspan="3" valign="top" width="601">
<p>CELLULAR ELEMENTS</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>EPITHELIAL CELLS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Drop Box</em></p>
<p>Present</p>
<p>Absent</p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>PUS CELLS</p>
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>Drop Box</em></p>
<p><em>1-2</em></p>
<p><em>2-3</em></p>
<p><em>3-4</em></p>
<p><em>4-5</em></p>
<p><em>&gt;5</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>RBC</p>
</td>
<td valign="top" width="174">
<p><em>Text Box</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>IMPRESSION</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (Big)</em></p>
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>COMMENTS</p>
</td>
<td valign="top" width="174">
<p><em>Text Box (Big)</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>Left signature</p>
<p>Drop Down</p>
</td>
<td valign="top" width="174">
<p>Center signature</p>
<p><em>&nbsp;</em></p>
<p>Drop Down</p>
</td>
<td valign="top" width="164">
<p>Right signature</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>Drop Down</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
<tr>
<td valign="top" width="264">
<p>&nbsp;</p>
</td>
<td valign="top" width="174">
<p><em>&nbsp;</em></p>
</td>
<td valign="top" width="164">
<p>&nbsp;</p>
</td>
</tr>
</tbody>
</table>
</div>
</div>
@endsection

        @push('js')
        <script src="{{ asset('dist/js/app.js')}}"></script>
        @endpush