<?php
namespace app\index\controller;
use think\Db;
use think\Controller;
use app\index\model\Login;
class Fadmin extends Controller
{
	public function tselect()
	{
		if(request()->ispost())
		{
			$rule=input('ruleid');
			$name=input('name');
            $data=[
                'name'=>input('name'),
            ];
            $validate=\think\Loader::validate('Fadmin');
            if(!$validate->check($data)){
                $this->error($validate->geterror());die;
            }
			if($rule==1)
			{
				$tid=Db::name('teachers')->where('teacherName','=',$name)->find();
                if($tid==null)
                {
                    return $this->error("该教师不存在！！");
                }
				$student=Db::name('attendance')->where('teacherId','=',$tid['teacherId'])->select();
				$s=0;
				foreach($student as $k=>$stu)
				{
				$student_name=Db::name('students')->where('studentId','=',$stu['studentId'])->find();
				$co_name=Db::name('course')->where('courseId','=',$stu['courseId'])->find();
				$c_id=Db::name('class')->where('class','=',$stu['class'])->find();
				$de_name=Db::name('department')->where('departmentId','=',$c_id['departmentId'])->find();
				$pr_name=Db::name('profession')->where('professionId','=',$c_id['professionId'])->find();
				$t_name=Db::name('teachers')->where('teacherId','=',$stu['teacherId'])->find();
				$state_name=Db::name('state')->where('stateId','=',$stu['stateId'])->find();
				$result[$s]=[
						'Id'=>$stu['Id'],
						'class'=>$stu['class'],
						'time'=>$stu['time'],
						'courseName'=>$co_name['courseName'],
						'name'=>$student_name['name'],
						'departmentName'=>$de_name['departmentName'],
						'professionName'=>$pr_name['professionName'],
						'teacherName'=>$t_name['teacherName'],
						'state'=>$state_name['state'],
				];
				$s=$s+1;
				$this->assign('result',$result);
				
				}
				return $this->fetch('result');
			}
			elseif($rule==3)
			{
				$d_name=Db::name('department')->where('departmentName','=',$name)->find();
				$s=0;
                if($d_name==null)
                {
                    return $this->error("该系部不存在！！");
                }
				$s_id=Db::name('students')->where('departmentId','=',$d_name['departmentId'])->select();
				foreach($s_id as $k=>$stu)
				{
				$student=Db::name('attendance')->where('studentId','=',$stu['studentId'])->find();
				$co_name=Db::name('course')->where('courseId','=',$student['courseId'])->find();
				$de_name=Db::name('department')->where('departmentId','=',$stu['departmentId'])->find();
				$pr_name=Db::name('profession')->where('professionId','=',$stu['professionId'])->find();
				$t_id=Db::name('teachers')->where('teacherId','=',$student['teacherId'])->find();
				$state_name=Db::name('state')->where('stateId','=',$student['stateId'])->find();
				$result[$s]=[
						'Id'=>$student['Id'],
						'class'=>$student['class'],
						'time'=>$student['time'],
						'courseName'=>$co_name['courseName'],
						'name'=>$stu['name'],
						'departmentName'=>$de_name['departmentName'],
						'professionName'=>$pr_name['professionName'],
						'teacherName'=>$t_id['teacherName'],
						'state'=>$state_name['state'],
				];
					$s=$s+1;
					$this->assign('result',$result);
				}
				return $this->fetch('dresult');
			}
			elseif($rule==2)
			{
				$student=Db::name('attendance')->where('class','=',$name)->select();
				$s=0;
                if($student==null)
                {
                    return $this->error("该班级不存在！！");
                }
				
				foreach($student as $k=>$stu)
				{
				$student_name=Db::name('students')->where('studentId','=',$stu['studentId'])->find();
				$co_name=Db::name('course')->where('courseId','=',$stu['courseId'])->find();
				$c_id=Db::name('class')->where('class','=',$stu['class'])->find();
				$de_name=Db::name('department')->where('departmentId','=',$c_id['departmentId'])->find();
				$pr_name=Db::name('profession')->where('professionId','=',$c_id['professionId'])->find();
				$t_name=Db::name('teachers')->where('teacherId','=',$stu['teacherId'])->find();
				$state_name=Db::name('state')->where('stateId','=',$stu['stateId'])->find();
				$result[$s]=[
						'Id'=>$stu['Id'],
						'class'=>$stu['class'],
						'time'=>$stu['time'],
						'courseName'=>$co_name['courseName'],
						'name'=>$student_name['name'],
						'departmentName'=>$de_name['departmentName'],
						'professionName'=>$pr_name['professionName'],
						'teacherName'=>$t_name['teacherName'],
						'state'=>$state_name['state'],
				];
				$s=$s+1;
				$this->assign('result',$result);
				
				}
				return $this->fetch('result');
			}
			elseif($rule==4)
			{
				$state_id=[
							'zc'=>0,
							'zt'=>0,
							'cd'=>0,
							'kk'=>0,
							'sj'=>0,
							'bj'=>0,
				];
				$studentid=Db::name('students')->where('name','=',$name)->find();
				$s=0;
                if($studentid==null)
                {
                    return $this->error("该学生不存在！！");
                }
				$student=Db::name('attendance')->where('studentId','=',$studentid['studentId'])->select();
				$this->assign('student',$student);
				foreach($student as $k=>$stu)
				{
					$course=Db::name('course')->where('courseId','=',$stu['courseId'])->find();
					$this->assign('course',$course);
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
					$result[$s]=[
						'courseName'=>$course['courseName'],
						'score'=>$score['score'],
								];
								$s=$s+1;
					$this->assign('state_id',$state_id);
					$this->assign('result',$result);

				}
			return $this->fetch('sresult');
			}
		}
		return $this->fetch();
	}
	public function classadd()
	{
		$coursename=input('coursename');
		$class=input('classname');
		$date=input('classdate');
		$week=input('classweek');
		$section=input('section');
		$classroom=input('classroom');
		$teachername=input('teachername');
		$course=Db::name('course')->where('courseName','=',$coursename)->find();
		$teacher=Db::name('teachers')->where('teacherName','=',$teachername)->find();
		if($course!=null&&$teacher!=null)
		{
			$data=[
			'courseId'=>$course['courseId'],
			'class'=>$class,
			'date'=>$date,
			'week'=>$week,
			'section'=>$section,
			'classroom'=>$classroom,
			'teacherId'=>$teacher['teacherId'],
			];
			$val=Db::table('schedule')->insert($data);
			if($val!==false)
			{
				return $this->success('添加成功');
			}
		}
		return $this->fetch();
	}
	public function all()
	{
		return $this->fetch();
	}
}
?>