<h1><?= out($headline) ?></h1>
<?php
flashdata();
echo '<p>'.anchor('jobs/create', 'Create New Job Record', array("class" => "button"));
if(strtolower(ENV) === 'dev') {
    echo anchor('api/explorer/jobs', 'API Explorer', array("class" => "button alt"));
}
echo '</p>';
echo Pagination::display($pagination_data);
if (count($rows)>0) { ?>
    <table id="results-tbl">
        <thead>
            <tr>
                <th colspan="10">
                    <div>
                        <div><?php
                        echo form_open('jobs/manage/1/', array("method" => "get"));
                        echo form_input('searchphrase', '', array("placeholder" => "Search records..."));
                        echo form_submit('submit', 'Search', array("class" => "alt"));
                        echo form_close();
                        ?></div>
                        <div>Records Per Page: <?php
                        $dropdown_attr['onchange'] = 'setPerPage()';
                        echo form_dropdown('per_page', $per_page_options, $selected_per_page, $dropdown_attr); 
                        ?></div>

                    </div>                    
                </th>
            </tr>
            <tr>
                <th>job date</th>
                <th>job name</th>
                <th>time in</th>
                <th>time out</th>
                <th>job hours</th>
                <th>Member ID</th>
                <th>cost code</th>
                <th>job code</th>
                <th>project id</th>
                <th style="width: 20px;">Action</th>            
            </tr>
        </thead>
        <tbody>
            <?php 
            $attr['class'] = 'button alt';
            foreach($rows as $row) { ?>
            <tr>
                <td><?= out($row->job_date) ?></td>
                <td><?= out($row->job_name) ?></td>
                <td><?= out($row->time_in) ?></td>
                <td><?= out($row->time_out) ?></td>
                <td><?= out($row->job_hours) ?></td>
                <td><?= out($row->member_id) ?></td>
                <td><?= out($row->cost_code) ?></td>
                <td><?= out($row->job_code) ?></td>
                <td><?= out($row->project_id) ?></td>
                <td><?= anchor('jobs/show/'.$row->id, 'View', $attr) ?></td>        
            </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php 
    if(count($rows)>9) {
        unset($pagination_data['include_showing_statement']);
        echo Pagination::display($pagination_data);
    }
}
?>