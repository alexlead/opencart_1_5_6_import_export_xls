<?php 
class ControllerToolExport extends Controller { 
	private $error = array();
	
	public function index() {
		$this->load->language('tool/export');
		$this->document->setTitle($this->language->get('heading_title'));
		$this->load->model('tool/export');

        if (isset($this->request->post['uploading_table'])){
           $switch_file_type = $this->request->post['uploading_table'];
        }
        
        if (isset($this->request->post['uploading_way'])){
          $mode_add_data = $this->request->post['uploading_way'];
        }
        
        
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            
            
			if ((isset( $this->request->files['upload'] )) && (is_uploaded_file($this->request->files['upload']['tmp_name']))) {
				$file = $this->request->files['upload']['tmp_name'];
				if ($this->model_tool_export->upload($file, $mode_add_data, $switch_file_type)) {
					$this->session->data['success'] = $this->language->get('text_success');
					$this->redirect($this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'));
				}
				else {
					$this->error['warning'] = $this->language->get('error_upload');
				}
			}
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['entry_restore'] = $this->language->get('entry_restore');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['button_import'] = $this->language->get('button_import');
		$this->data['button_export'] = $this->language->get('button_export');
        $this->data['button_export_cat'] = $this->language->get('button_export_cat');
        $this->data['button_export_prod'] = $this->language->get('button_export_prod');
		$this->data['tab_general'] = $this->language->get('tab_general');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->data['breadcrumbs'] = array();

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => FALSE
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => ' :: '
		);
		
		$this->data['action'] = $this->url->link('tool/export', 'token=' . $this->session->data['token'], 'SSL');
		
        $this->data['import_by_id'] = $this->url->link('tool/export/download_product_by_id', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['export'] = $this->url->link('tool/export/download', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['export_cat'] = $this->url->link('tool/export/download_categories', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['export_prod'] = $this->url->link('tool/export/download_product', 'token=' . $this->session->data['token'], 'SSL');

		$this->template = 'tool/export.tpl';
		$this->children = array(
			'common/header',
			'common/footer',
		);
		$this->response->setOutput($this->render());
	}


    public function download_categories() {
        $this->download(1);
    }
    
    public function download_product() {
        $this->download(2);
    }
    
    public function download_product_by_id() {
        
        $this->download(0);
    }
	public function download($act=0) {
		if ($this->validate()) {

			// set appropriate timeout limit
			set_time_limit( 1800 );

			// send the categories, products and options as a spreadsheet file
			$this->load->model('tool/export');
			$this->model_tool_export->download($act);

		} else {

			// return a permission error page
			return $this->forward('error/permission');
		}
	}


	private function validate() {
		if (!$this->user->hasPermission('modify', 'tool/export')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}
	}
}
?>