<?php

Class M_home extends CI_Model{

    function selectBU($hasil){
        $bu = $this->session->userdata('BU_ID');
        $query = $this->db->query("select BU_NAME FROM P_BU WHERE BU_ID=''".$bu.'');

    }

    function assignmentView($user_id){
        $query = $this->db->query("SELECT * from user_task where user_id='".$user_id."'");
        $hasil = $query->result_array();
        return $hasil;
    }
    function assignmentProject($id){
        return $this->db->query("select * from v_project_team_member where user_id='". $id ."'")->result_array();
    }

    function getTotalHour($user_id,$bulan,$tahun)
    {
        return $this->db->query("SELECT
      SUM(HOUR_TOTAL) AS JML_JAM_BULANAN, TO_CHAR (TS_DATE, 'mm')
      FROM
      user_timesheet b
      WHERE
      user_id = '".$user_id."'
      AND TO_CHAR (TS_DATE, 'mm') = '".$bulan."'
      AND TO_CHAR (TS_DATE, 'yyyy') = '".$tahun."'
      GROUP BY user_id,TO_CHAR (TS_DATE, 'mm')
      UNION ALL
      SELECT 0,'".$bulan."'
      FROM dual
      WHERE NOT EXISTS (SELECT SUM(HOUR_TOTAL) AS JML_JAM_BULANAN, TO_CHAR (TS_DATE, 'mm')
      FROM user_timesheet b
      WHERE
      user_id = '".$user_id."'
      AND TO_CHAR (TS_DATE, 'mm') = '".$bulan."'
      AND TO_CHAR (TS_DATE, 'yyyy') = '".$tahun."'
      GROUP BY user_id,TO_CHAR (TS_DATE, 'mm'))
      ")->row()->JML_JAM_BULANAN;
    }
    function getEntry($user_id,$bulan,$tahun)
    {
        return $this->db->query("SELECT
        COUNT (DISTINCT ts_date) AS jml_entry_bulanan,
        TO_CHAR (TS_DATE, 'mm') as BULAN,
        user_id
        FROM user_timesheet
        WHERE
        user_id = '".$user_id."'
        AND TO_CHAR (TS_DATE, 'mm') = '".$bulan."'
        AND TO_CHAR (TS_DATE, 'yyyy') = '".$tahun."'
        AND (HOUR_TOTAL is not null and HOUR_TOTAL!='0')
        GROUP BY
        user_id, TO_CHAR (TS_DATE, 'mm')
        UNION ALL
        SELECT 0,'".$bulan."','".$user_id."'
        FROM dual
        WHERE NOT EXISTS (SELECT
        COUNT (DISTINCT ts_date) AS jml_entry_bulanan,
        TO_CHAR (TS_DATE, 'mm') as BULAN,
        user_id
        FROM user_timesheet
        WHERE
        user_id = '".$user_id."'
        AND TO_CHAR (TS_DATE, 'mm') = '".$bulan."'
        AND TO_CHAR (TS_DATE, 'yyyy') = '".$tahun."'
        AND (HOUR_TOTAL is not null and HOUR_TOTAL!='0')
        GROUP BY
        user_id, TO_CHAR (TS_DATE, 'mm'))")->row()->JML_ENTRY_BULANAN;
    }

    function getAllEntry($user_id,$tahun)
    {
        return
            $this->db->query("SELECT DISTINCT
          m.MONTH_DISPLAY,
          m.MONTH_VALUE,
          coalesce(ts.JML_ENTRY_BULANAN, 0) as JML_ENTRY_BULANAN,
          coalesce(ts.USER_ID, '".$user_id."') as user_id
          FROM
          (SELECT
          COUNT(DISTINCT ts_date) as JML_ENTRY_BULANAN,
          TO_CHAR (TS_DATE, 'mm') as BULAN,
          user_id
          FROM
          user_timesheet JOIN
          WORK_DAY m
          ON m.wd_id = TO_CHAR (TS_DATE, 'mm')
          WHERE
          user_id = '".$user_id."'
          AND TO_CHAR (TS_DATE, 'yyyy') = '".$tahun."'
          AND (HOUR_TOTAL is not null and HOUR_TOTAL!='0')
          GROUP BY
          user_id, TO_CHAR (TS_DATE, 'mm')) ts
          RIGHT outer JOIN WWV_FLOW_MONTHS_MONTH m ON ts.BULAN = m.MONTH_VALUE
          ORDER BY MONTH_VALUE")->result_array();
    }

    function getAllHour($user_id,$tahun)
    {
        return
            $this->db->query("SELECT DISTINCT
            m.MONTH_DISPLAY,
            m.MONTH_VALUE,
            coalesce(ts.JML_JAM_BULANAN, 0) as JML_JAM_BULANAN,
            coalesce(ts.USER_ID, '".$user_id."') as user_id
            FROM
            (SELECT
            SUM(HOUR_TOTAL) AS JML_JAM_BULANAN, TO_CHAR (TS_DATE, 'mm')  as BULAN,USER_ID
            FROM
            user_timesheet b
            WHERE
            user_id = '".$user_id."'
            AND TO_CHAR (TS_DATE, 'yyyy') = '".$tahun."'
            GROUP BY user_id,TO_CHAR (TS_DATE, 'mm')) ts
            RIGHT outer JOIN WWV_FLOW_MONTHS_MONTH m ON ts.BULAN = m.MONTH_VALUE
            ORDER BY MONTH_VALUE")->result_array();
    }

    function getProjects($user){
        return $this->db->query("select rp.*, pr.project_name
            from resource_pool rp left join projects pr on rp.project_id=pr.project_id where user_id='$user'")->result();
    }
}