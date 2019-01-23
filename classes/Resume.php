<?php

/* 
    Created on : 15-Jul-2018, 06:02:39 PM
    Author     : Marc Freir
    License    : This work is licensed under a Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International License.
*/

class Resume
{
    /*
    public static function showResume()
    {
        $resumeinfo = DB::query('SELECT tb_resume.resume_name,
                                        tb_resume.resume_position,
                                        tb_resume.resume_contact,
                                        tb_resume.resume_summary,
                                        tb_resume.resume_blood_donor,
                                        tb_resume.resume_languages,
                                        tb_resume.resume_interests,
                                        tb_resume.resume_posted_at,
                                        tb_resume_education.resume_education_school,
                                        tb_resume_education.resume_education_degree,
                                        tb_resume_education.resume_education_field_of_study,
                                        tb_resume_education.resume_education_activities,
                                        tb_resume_education.resume_education_start_date,
                                        tb_resume_education.resume_education_finish_date,
                                        tb_resume_experience.resume_experience_title,
                                        tb_resume_experience.resume_experience_company,
                                        tb_resume_experience.resume_experience_location,
                                        tb_resume_experience.resume_experience_start_date,
                                        tb_resume_experience.resume_experience_finish_date,
                                        tb_resume_experience.resume_experience_description,
                                        tb_resume_skills.resume_skills_title,
                                        tb_resume_my_articles.resume_my_articles_title,
                                        tb_resume_my_articles.resume_my_articles_media,
                                        tb_resume_my_books.resume_my_books_title,
                                        tb_resume_my_books.resume_my_books_media,
                                        tb_resume_projects.resume_projects_title,
                                        tb_resume_projects.resume_projects_media,
                                        tb_resume_portfolio.resume_portfolio_title,
                                        tb_resume_portfolio.resume_portfolio_media,
                                        tb_resume_volunteer_experience.resume_volunteer_experience_title,
                                        tb_resume_volunteer_experience.resume_volunteer_experience_company,
                                        tb_resume_volunteer_experience.resume_volunteer_experience_location,
                                        tb_resume_volunteer_experience.resume_volunteer_experience_start_date,
                                        tb_resume_volunteer_experience.resume_volunteer_experience_finish_date,
                                        tb_resume_volunteer_experience.resume_volunteer_experience_description,
                                        tb_resume_nonprofit_work.resume_nonprofit_work_title,
                                        tb_resume_nonprofit_work.resume_nonprofit_work_company,
                                        tb_resume_nonprofit_work.resume_nonprofit_work_location,
                                        tb_resume_nonprofit_work.resume_nonprofit_work_start_date,
                                        tb_resume_nonprofit_work.resume_nonprofit_work_finish_date,
                                        tb_resume_nonprofit_work.resume_nonprofit_work_description
        FROM tb_resume
        INNER JOIN tb_resume_education ON tb_resume.resume_id = tb_resume_education.resume_education_resume_id
        INNER JOIN tb_resume_experience ON tb_resume.resume_id = tb_resume_experience.resume_experience_resume_id
        INNER JOIN tb_resume_skills ON tb_resume.resume_id = tb_resume_skills.resume_skills_resume_id
        INNER JOIN tb_resume_my_articles ON tb_resume.resume_id = tb_resume_my_articles.resume_my_articles_resume_id
        INNER JOIN tb_resume_my_books ON tb_resume.resume_id = tb_resume_my_books.resume_my_books_resume_id
        INNER JOIN tb_resume_projects ON tb_resume.resume_id = tb_resume_projects.resume_projects_resume_id
        INNER JOIN tb_resume_portfolio ON tb_resume.resume_id = tb_resume_portfolio.resume_portfolio_resume_id
        INNER JOIN tb_resume_volunteer_experience ON tb_resume.resume_id = tb_resume_volunteer_experience.resume_volunteer_experience_resume_id
        INNER JOIN tb_resume_nonprofit_work ON tb_resume.resume_id = tb_resume_nonprofit_work.resume_nonprofit_work_resume_id;');
    }
    */

    public static function controlResume()
    {
        $page = isset($_GET['p'])?$_GET['p']:'';
        //$page = isset($_GET['p']);
        

        //FROM USER SESSION - BEGINNING
        /*
        $session_userid = "";
        $session_username = "";

        $userid = Login::isLoggedIn();

        $session_userid = DB::query('SELECT usersession_user_id FROM tb_usersession WHERE usersession_user_id=:usersession_user_id', array(':usersession_user_id'=>$userid))[0]['usersession_user_id'];
        $session_username = DB::query('SELECT usernamesession FROM tb_usersession WHERE usersession_user_id=:usersession_user_id', array(':usersession_user_id'=>$userid))[0]['usernamesession'];
        //FROM USER SESSION - END

        echo "<h4>Who am I? ".$session_username."</h4>";
        echo "<h4>My ID: ".$session_userid."</h4>";
        echo "<h4>Param: ".$page."</h4>";
        */

        if ($page == 'add')
        {
            $name = $_POST['nm'];
            $position = $_POST['pst'];
            $contact = $_POST['ct'];
            $summary = $_POST['smr'];
            $blood_donor = $_POST['bd'];
            $languages = $_POST['lg'];
            $interests = $_POST['itr'];

            //$stmt = DB::query('INSERT INTO tb_resume VALUES (\'\', :userid, :username, ?, ?, ?, ?, ?, ?, ?, NOW())', array(':userid'=>$session_userid, ':username'=>$session_username));
            //TEST
            //$stmt = DB::query('INSERT INTO tb_resume VALUES (\'\', :userid, :username, :nameuser, :position, :contact, :summary, :blooddonor, :languages, :interests, NOW())', array(':userid'=>$session_userid, ':username'=>$session_username, ':nameuser'=>$name, ':position'=>$position, ':contact'=>$contact, ':summary'=>$summary, ':blooddonor'=>$blood_donor, ':languages'=>$languages, ':interests'=>$interests));
            //NEW TEST
            //$stmt = DB::query('INSERT INTO tb_resume VALUES ("", ?, ?, ?, ?, ?, ?, ?, NOW())');
            $stmt = DB::query('INSERT INTO tb_resume VALUES ("", ?, ?, ?, ?, ?, ?, ?');
            
            $stmt->bindParam(1,$name);
            $stmt->bindParam(2,$position);
            $stmt->bindParam(3,$contact);
            $stmt->bindParam(4,$summary);
            $stmt->bindParam(5,$blood_donor);
            $stmt->bindParam(6,$languages);
            $stmt->bindParam(7,$interests);
            
            //TEST
            /*
            $stmt->bindParam(1, $uid);
            $stmt->bindParam(2, $uname);
            $stmt->bindParam(3, $name);
            $stmt->bindParam(4, $name);
            $stmt->bindParam(5, $position);
            $stmt->bindParam(6, $contact);
            $stmt->bindParam(7, $summary);
            $stmt->bindParam(8, $blood_donor);
            $stmt->bindParam(9, $languages);
            $stmt->bindParam(10, $interests);
            */
            $stmt->execute();
        }
        else if ($page == 'edit')
        {

        }
        else if ($page == 'del')
        {

        }
        else
        {

        }
    }
}

?>