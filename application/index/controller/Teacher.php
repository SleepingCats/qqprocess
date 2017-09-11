<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
class Teacher extends Controller
{
	public function	lst()
	{
		
		 $tid=input('tid');
		 $cid=input('cid');
        $s=0;
		$data=Db::table('attendance')->where('teacherId','=',$tid)
									 ->where('class','=',$cid)
									 ->select();
        $result=Array();
            foreach ($data as $k => $stu) {
                $student_name = Db::name('students')->where('studentId', '=', $stu['studentId'])->find();
                $co_name = Db::name('course')->where('courseId', '=', $stu['courseId'])->find();
                $c_id = Db::name('class')->where('class', '=', $stu['class'])->find();
                $de_name = Db::name('department')->where('departmentId', '=', $c_id['departmentId'])->find();
                $pr_name = Db::name('profession')->where('professionId', '=', $c_id['professionId'])->find();
                $t_name = Db::name('teachers')->where('teacherId', '=', $stu['teacherId'])->find();
                $state_name = Db::name('state')->where('stateId', '=', $stu['stateId'])->find();
                $s_score = Db::name('score')->where('studentId', '=', $stu['studentId'])->find();

                $result[$s] = [
                    'Id' => $stu['Id'],
                    'class' => $stu['class'],
                    'studentName' => $student_name['name'],
                    'courseName' => $co_name['courseName'],
                    'departmentName' => $de_name['departmentName'],
                    'professionName' => $pr_name['professionName'],
                    'teacherName' => $t_name['teacherName'],
                    'stateName' => $state_name['state'],
                    'scoreName'=>$s_score['score'],
                ];
                $s=$s+1;
//		$this->assign('data',$data);
//		$this->assign('student_name',$student_name);
//		$this->assign('co_name',$co_name);
//		$this->assign('de_name',$de_name);
//		$this->assign('pr_name',$pr_name);
//		$this->assign('t_name',$t_name);
//		$this->assign('state_name',$state_name);
//		$this->assign('s_score',$s_score);
                $this->assign('result', $result);


            }
        return $this->fetch();


	}
	public function edit()
	{
		$sid=input('sid');
		$student=db('attendance')->find($sid);
		$student_name=Db::name('students')->where('studentId','=',$student['studentId'])->find();
		$course_id=Db::name('course')->where('courseId','=',$student['courseId'])->find();
		$t_name=Db::name('teachers')->where('teacherId','=',$student['teacherId'])->find();
		$this->assign('student',$student);
		$this->assign('student_name',$student_name);
		$this->assign('course_id',$course_id);
		$this->assign('t_name',$t_name);
		if(request()->ispost())
		{
		$state=input('state');
		$s_score=Db::name('score')->where('studentId','=',$student['studentId'])
									->where('courseId','=',$student['courseId'])
									->find();
		$score=$s_score['score'];
		$val=Db::table('attendance')->where('Id',$sid)->update(['stateId'=>$state]);
		if($val!==false)
		{
			if($state==2&&$score>=80)
			{
				$n_score=$score-1;
				Db::table('score')->where('studentId',$student['studentId'])->update(['score'=>$n_score]);
			}
			if($state=3&&$score>=80)
			{
				$n_score=$score-2;
				Db::table('score')->where('studentId',$student['studentId'])->update(['score'=>$n_score]);
			}
			if($state=6&&$score>=80)
			{
				$n_score=$score-2;
				Db::table('score')->where('studentId',$student['studentId'])->update(['score'=>$n_score]);
			}
		}
		if($val!==false)
		{
		$data=db('attendance')->find($sid);
		$list=Db::name('schedule')->where('teacherId','=',$data['teacherId'])->select();
				foreach($list as $k=>$val)//遍历教师ID  查询教师管理课程
				{
				$course_Name=Db::name('course')->where('courseId','=',$val['courseId'])->find();
				$class_view=Db::name('class')->where('class','=',$val['class'])->find();
				$de_name=Db::name('department')->where('departmentId','=',$class_view['departmentId'])->find();
				$pr_name=Db::name('profession')->where('professionId','=',$class_view['professionId'])->find();
				$this->assign('de_name',$de_name);
				$this->assign('pr_name',$pr_name);
				$this->assign('course_Name',$course_Name);
				$this->assign('list',$list);
				}
				return $this->fetch('index/teacher');
//		foreach($data as $k=>$stu)
//		{
//			$student_name=Db::name('students')->where('studentId','=',$stu['studentId'])->find();
//			$co_name=Db::name('course')->where('courseId','=',$stu['courseId'])->find();
//			$c_id=Db::name('class')->where('class','=',$stu['class'])->find();
//			$de_name=Db::name('department')->where('departmentId','=',$c_id['departmentId'])->find();
//			$pr_name=Db::name('profession')->where('professionId','=',$c_id['professionId'])->find();
//			$t_name=Db::name('teachers')->where('teacherId','=',$stu['teacherId'])->find();
//			$state_name=Db::name('state')->where('stateId','=',$stu['stateId'])->find();
//			$s_score=Db::name('score')->where('studentId','=',$stu['studentId'])->find();
//		$this->assign('data',$data);
//		$this->assign('student_name',$student_name);
//		$this->assign('co_name',$co_name);
//		$this->assign('de_name',$de_name);
//		$this->assign('pr_name',$pr_name);
//		$this->assign('t_name',$t_name);
//		$this->assign('state_name',$state_name);
//		$this->assign('s_score',$s_score);
//		return $this->fetch('lst');
//		}
		}
		else{
			return $this->error("修改失败");
		}
		}
		return $this->fetch();
	}
	public function allin()
	{
		$t_id=input('tid');
		$c_id=input('cid');
		$state_id=[
		'zc'=>0,
		'zt'=>0,
		'cd'=>0,
		'kk'=>0,
		'sj'=>0,
		'bj'=>0,
		];
		$data=Db::table('attendance')->where('teacherId','=',$t_id)
									 ->where('class','=',$c_id)
									 ->select();
		$s=0;
		foreach($data as $k=>$stu)
		{
			$student=Db::name('students')->where('studentId','=',$stu['studentId'])
										->find();
			
			if($stu['stateId']==1)
			{
				$state_id['zc']=$state_id['zc']+1;
			}
			elseif($stu['stateId']==2)
			{
				$state_id['cd']=$state_id['cd']+1;
			}
			elseif($stu['stateId']==3)
			{
				$state_id['kk']=$state_id['kk']+1;
			}
			elseif($stu['stateId']==4)
			{
				$state_id['bj']=$state_id['bj']+1;
			}
			elseif($stu['stateId']==5)
			{
				$state_id['sj']=$state_id['sj']+1;
			}
			elseif($stu['stateId']==6)
			{
				$state_id['zt']=$state_id['zt']+1;
			}
			$score=Db::name('score')->where('studentId','=',$stu['studentId'])
									->where('courseId','=',$stu['courseId'])
									->find();
//			$this->assign('score',$score);
         		$result[$s] = [
                    'studentName'=>$student['name'],
                    'score'=>$score['score'],
                ];
                $s=$s+1;

		}
			$this->assign('state_id',$state_id);
			$this->assign('result',$result);
			return $this->fetch();

	}
}
?>