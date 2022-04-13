<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="<?php echo base_url() ?>assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<style>
.center {
  text-align: center;
}

.width-inherit {
  width: inherit !important;
}

.text-message{
  font-size: 0.9rem;
  font-weight: 500;
}

.modalMessageIcon {
  font-size: 35pt;
}

.modalMessageContent {
  font-size: 13pt;
}

.btn-modal{
  width: 65px;
}

.column {
  float: left;
}

.col-left {
  width: 50%;
}

.col-right {
  width: 50%;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}  

ul, li.tl-list{
  list-style: none;
  padding: 0;
}

.sessions{
  margin-top: 1rem;
  margin-left: 1rem;
  border-radius: 12px;
  position: relative;
  font-size: 14px;
}
li.tl-list{
  padding-bottom: 0.2rem;
  border-left: 1px solid #6c757d;
  position: relative;
  padding-left: 20px;
  margin-left: 10px;
}

li.tl-list::last-child {
  border: 0px;
  padding-bottom: 0;
}

li.tl-list::before {
  content: '';
  width: 15px;
  height: 15px;
  background: white;
  border: 1px solid #3b3b3b;
  box-shadow: 3px 3px 0px #6c757d;  
  border-radius: 50%;
  position: absolute;
  left: -10px;
  top: 0px;
}

.time{  
  font-weight: 500;
}

p.tl-detail{    
  line-height: 1;
  /*margin-top:0.4rem;  */
}

p.tl-detail-note{      
  margin-top:-15px;  
}

</style>