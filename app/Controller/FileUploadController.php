<?php

class FileUploadController extends AppController {
	public function index() {
		$this->set('title', __('File Upload Answer'));
		$file_uploads = $this->FileUpload->find('all');
		$this->set(compact('file_uploads'));

		if ($this->request->is('post')) {
			$file = $this->request->data['FileUpload']['file']['tmp_name'];
			$file_data = array();
			ini_set('auto_detect_line_endings', TRUE);
			$row = 1;
			if (($handle = fopen($file, "r")) !== FALSE) {
					fgetcsv($handle,1000,",");//remove the headers
					while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			        $row++;
			        array_push($file_data,array('name' => $data[0],'email' => $data[1]));
			    }
			    fclose($handle);
			}
			ini_set('auto_detect_line_endings', FALSE);
			$this->FileUpload->saveMany($file_data);
			return $this->redirect([]);//redirect to same page to remove post data

		}
	}
}
