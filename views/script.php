<script>
$(document).ready(function() {
    $(document).on('click', '.page', function(){    
        var rel = $(this).attr('rel');
        var rel2 = "<?=base_url()?>ppaa/ruang/cekRuangKosong";
        //alert(rel2);
        if(rel == rel2 ){
            $('#content').load(rel, function(){
                init();
            });
        } else {
            $('#content').load(rel);
        }
        
        //$('.content').html(rel);
    });

    /*$(document).on('shown.bs.modal', '.modal', function(){
         $('#tgl_kegiatan, #tgl_permohonan').datepicker({
          autoclose: true,
          language: "id",
          container:'modal'
        });  
    });*/

    /***********************  form peminjaman  *************************/
    $(document).on('click', '.test', function(event){
        vhari           = $('#hari').val();
        vtgl_kegiatan   = $('#tgl_kegiatan').val();
        vruang          = $('#ruang').val();
        vnama_kegiatan  = $('#nama_kegiatan').val();
        vprodi          = $('#prodi').val();
        vjam_mulai      = $('#jam_mulai').val();
        vmenit_mulai    = $('#menit_mulai').val();
        vjam_selesai    = $('#jam_selesai').val();
        vmenit_selesai  = $('#menit_selesai').val();
        tgl_permohonan  = $('#tgl_permohonan').val();
        nama_peminjam   = $('#nama_peminjam').val();
        id_peminjam     = $('#id_peminjam').val();
        no_telp         = $('#no_telp').val();
        email           = $('#email').val();
        jml_peserta     = $('#jml_peserta').val();
                
        //alert(vhari+" "+vtgl_kegiatan+" "+vruang+" "+vnama_kegiatan+" "+vprodi+" "+vjam_mulai+" "+vmenit_mulai+" "+vjam_selesai+" "+vmenit_selesai);
        //$("#process-info").show();

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "ppaa/ruang/simpanData",
            dataType: "json", 
            data: {
                tgl_kegiatan:vtgl_kegiatan, 
                ruang:vruang, 
                nama_kegiatan:vnama_kegiatan, 
                prodi:vprodi, 
                jam_mulai:vjam_mulai,
                menit_mulai:vmenit_mulai, 
                jam_selesai:vjam_selesai, 
                menit_selesai:vmenit_selesai, 
                tgl_permohonan:tgl_permohonan, 
                nama_peminjam:nama_peminjam, 
                id_peminjam:id_peminjam, 
                no_telp:no_telp, 
                email:email, 
                jml_peserta:jml_peserta, 
                crud:1},
            success: function(res) {
                $("div.pesan").html(res.flag);
                if (res.flag == '1')  //jika pesan bentrok
                {
                    console.log(res.pesan)
                    $(".pesan").html(res.pesan);
                    $(".pesan").fadeIn();
                } else {
                    console.log(res.pesan)
                    $(".pesan").fadeIn();
                    $(".pesan").html(res.pesan);
                    $(".pesan").fadeOut(2300);
                }
            }
        });
    });

    /*
    //cek jadwal bentrok
    $(document).on('change', ".ruang, .jam_mulai, .jam_selesai, .menit_mulai, .menit_selesai", function(){
        //alert('test')
        var ruang       = $(this).parent().parent().find('#ruang').val();
        var tgl_kegiatan= $(this).parent().parent().find('#tgl_kegiatan').val();
        var jam_mulai   = $(this).parent().parent().find('#jam_mulai').val();
        var jam_selesai = $(this).parent().parent().find('#jam_selesai').val();
        var menit_mulai = $(this).parent().parent().find('#menit_mulai').val();
        var menit_selesai = $(this).parent().parent().find('#menit_selesai').val();
        alert(ruang + ' ' + tgl_kegiatan + ' ' + jam_mulai + ' ' + menit_mulai + ' ' + jam_selesai + ' ' + menit_selesai);
        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>" + "ppaa/ruang/cekJadwalBentrok",
            data: {
                ruang:ruang,  
                tgl_kegiatan:tgl_kegiatan,
                jam_mulai:jam_mulai,
                jam_selesai:jam_selesai,
                menit_mulai:menit_mulai,
                menit_selesai:menit_selesai
            },
            success: function(data) {
                $('.pesan-bentrok').html(data);
            }
        });  
    })
    */

    //rubah inputan format tanggal kegiatan ke bahasa Indonesia
    $(document).on('change', '#tgl_kegiatan', function(){
        var array_bln = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
        var array_hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        var array_tgl = $('#tgl_kegiatan').val().split('/');
        var tgl = $('#tgl_kegiatan').val();
        var tanggal = new Date(tgl);
        var yy = tanggal.getYear();
        var tahun = (yy < 1000) ? yy + 1900 : yy;
        var kd_bulan = tanggal.getMonth();
        var d = array_tgl[1];
        var kd_hari = tanggal.getDay();
        var hari = array_hari[kd_hari];
        var bulan = array_bln[kd_bulan];
        var tanggalan = hari + ', ' + d + ' ' + bulan + ' ' + tahun;
        $('#tgl_kegiatan').val(tanggalan);
    });

    //rubah inputan format tanggal permohonan ke bahasa Indonesia
    $(document).on('change', '#tgl_permohonan', function(){
        var array_bln = ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
        var array_hari = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
        var array_tgl = $('#tgl_permohonan').val().split('/');
        var tgl = $('#tgl_permohonan').val();
        var tanggal = new Date(tgl);
        var yy = tanggal.getYear();
        var tahun = (yy < 1000) ? yy + 1900 : yy;
        var kd_bulan = tanggal.getMonth();
        var d = array_tgl[1];
        var kd_hari = tanggal.getDay();
        var hari = array_hari[kd_hari];
        var bulan = array_bln[kd_bulan];
        var tanggalan = hari + ', ' + d + ' ' + bulan + ' ' + tahun;
        $('#tgl_permohonan').val(tanggalan);
    });

    /***********************  isian edit form peminjaman  *************************/
    $(document).on('click', '.form-edit', function(){
        var nomor = $(this).attr('id');
        console.log(nomor)
        //set komponen jam
        var array_jam = [];
        for (i=8; i<24; i++) {
            jam = (i<10) ? '0'+i : i ;
            array_jam.push(jam);
        };

        //set komponen menit
        var array_menit = [];
        for (i=0; i<61; i+=5) {
            menit = (i<10) ? '0'+i : i ;
            array_menit.push(menit);
        };

        $.ajax({
            type    : "POST",
            url     : "<?php echo base_url()?>ppaa/ruang/formEdit",
            data    : {nomor:nomor},
            dataType: "json",
            success : function(data){
                //console.log(data)
                //set ruangan
                var ruang = '<select id="ruang" name="ruang" class="ruang form-control" style="width: 100px">';
                $.each(data.select_ruang, function (key, value) {
                        if(key == data.ruang){
                            ruang+= '<option value="' + key + '" selected >' + value + '</option>';
                        } else {
                            ruang+= '<option value="' + key + '">' + value + '</option>';
                        }   
                });
                ruang+='</select>';

                //set jam mulai
                var jam_mulai = '<select id="jam_mulai" class="jam_mulai form-control">';
                $.each(array_jam, function (key, value) {
                    if (value == data.jam_mulai) {
                        jam_mulai += '<option value="' + value +'" selected>' + value + '</option>';
                    } else {
                        jam_mulai += '<option value="' + value +'">' + value + '</option>';
                    }               
                });
                jam_mulai += '</select>';

                //set menit mulai
                var menit_mulai = '<select id="menit_mulai" class="menit_mulai form-control">';
                $.each(array_menit, function (key, value) {
                    if (value == data.menit_mulai) {
                        menit_mulai += '<option value="' + value +'" selected>' + value + '</option>';
                    } else {
                        menit_mulai += '<option value="' + value +'">' + value + '</option>';
                    }               
                });
                menit_mulai += '</select>';

                //set jam selesai
                var jam_selesai = '<select id="jam_selesai" class="jam_selesai form-control">';
                $.each(array_jam, function (key, value) {
                    if (value == data.jam_selesai) {
                        jam_selesai += '<option value="' + value +'" selected>' + value + '</option>';
                    } else {
                        jam_selesai += '<option value="' + value +'">' + value + '</option>';
                    }               
                });
                jam_selesai += '</select>';

                //set menit selesai
                var menit_selesai = '<select id="menit_selesai" class="menit_selesai form-control">';
                $.each(array_menit, function (key, value) {
                    if (value == data.menit_selesai) {
                        menit_selesai += '<option value="' + value +'" selected>' + value + '</option>';
                    } else {
                        menit_selesai += '<option value="' + value +'">' + value + '</option>';
                    }               
                });
                menit_selesai += '</select>';

                //isi data form edit
                $('#event_id').val(data.event_id);
                $('#nomor').val(data.nomor);
                $('#tgl_kegiatan').val(data.tgl_kegiatan);
                $('#tgl_permohonan').val(data.tgl_permohonan);
                $('#nama_kegiatan').val(data.nama_kegiatan);
                $('#prodi').val(data.prodi);
                $('#jml_peserta').val(data.jml_peserta);
                $('#nama_peminjam').val(data.nama_peminjam);
                $('#id_peminjam').val(data.id_peminjam);
                $('#no_telp').val(data.no_telp);
                $('#email').val(data.email);                
                $('#jam_mulai').val(data.jam_mulai);
                $('#menit_mulai').val(data.menit_mulai);
                $('#jam_selesai').val(data.jam_selesai);
                $('#menit_selesai').val(data.menit_selesai);
                $('#ruangan').html(ruang);
                $('#mulai').html(jam_mulai + ' : ' + menit_mulai);
                $('#selesai').html(jam_selesai + ' : ' + menit_selesai);

                $.each(data, function(key, value){
                    console.log(key + ' ' + value + ' ' + data.ruang);  
                });
                          
            }
        });
    });

    //edit data peminjaman
    $(document).on('click', '.edit-data', function(){
        nomor           = $('#nomor').val();
        event_id        = $('#event_id').val();
        vtgl_kegiatan   = $('#tgl_kegiatan').val();
        vruang          = $('#ruang').val();
        vnama_kegiatan  = $('#nama_kegiatan').val();
        vprodi          = $('#prodi').val();
        vjam_mulai      = $('#jam_mulai').val();
        vmenit_mulai    = $('#menit_mulai').val();
        vjam_selesai    = $('#jam_selesai').val();
        vmenit_selesai  = $('#menit_selesai').val();
        tgl_permohonan  = $('#tgl_permohonan').val();
        nama_peminjam   = $('#nama_peminjam').val();
        id_peminjam     = $('#id_peminjam').val();
        no_telp         = $('#no_telp').val();
        email           = $('#email').val();
        jml_peserta     = $('#jml_peserta').val();
                
        //alert(nomor + " " +vtgl_kegiatan+" ruang="+vruang+" "+vnama_kegiatan+" "+vprodi+" "+vjam_mulai+" "+vmenit_mulai+" "+vjam_selesai+" "+vmenit_selesai);

        $.ajax({
            type: "POST",
            url: "<?=base_url()?>" + "ppaa/ruang/editData",
            dataType: "json",     
            data: {
                event_id        :event_id,           
                nomor           :nomor,
                tgl_kegiatan    :vtgl_kegiatan, 
                ruang           :vruang, 
                nama_kegiatan   :vnama_kegiatan, 
                prodi           :vprodi, 
                jam_mulai       :vjam_mulai,
                menit_mulai     :vmenit_mulai, 
                jam_selesai     :vjam_selesai, 
                menit_selesai   :vmenit_selesai, 
                tgl_permohonan  :tgl_permohonan, 
                nama_peminjam   :nama_peminjam, 
                id_peminjam     :id_peminjam, 
                no_telp         :no_telp, 
                email           :email, 
                jml_peserta     :jml_peserta, 
                crud            :1
            },
            success: function(res) {
                console.log(res.flag)
                if (res.flag == '1')  //jika pesan bentrok
                {
                    console.log(res.pesan)
                    $(".pesan").html(res.pesan);
                    $(".pesan").fadeIn();
                } else {
                    console.log(res.pesan)
                    $(".pesan").html(res.pesan);
                    $(".pesan").fadeIn();
                    $(".pesan").fadeOut(2300);
                }
            }
        });
    });
    
    //delete data peminjaman
    $(document).on('click', '.del', function(){
        var nomor = $(this).attr('id');
        var event_name = $(this).parent().find('.event-name').text();
        
        //tanyain dulu..
        var pesan;
        var r = confirm('Anda yakin akan menghapus data kegiatan ' + event_name + '?');
        if(r == true){
            //delete
            $.ajax({
                type    : "POST",
                url     : "<?php echo base_url()?>ppaa/ruang/deleteData",
                data    : {nomor:nomor},
                success : function(data){
                    $('#dg').html(data);
                }
            });
        }
    });
});

    function init() {

        var sections=[
            {key:"AJS" ,label:"AJS<br>150"},
            {key:"E.103A" ,label:"E.103A<br>35"},
            {key:"E.103B" ,label:"E.103B<br>35"},
            {key:"E.201" ,label:"E.201<br>35"},
            {key:"E.202" ,label:"E.202<br>10"},
            {key:"E.203A" ,label:"E.203A<br>35"},
            {key:"E.203B" ,label:"E.203B<br>35"},
            {key:"E.204" ,label:"E.204<br>20"},
            {key:"E.301" ,label:"E.301<br>40"},
            {key:"E.302" ,label:"E.302<br>40"},
            {key:"E.303" ,label:"E.303<br>40"},
            {key:"E.304" ,label:"E.304<br>40"},
            {key:"F.201" ,label:"F.201<br>10"},
            {key:"F.202" ,label:"F.202<br>60"},
            {key:"G.106" ,label:"G.106"},
            {key:"G.201" ,label:"G.201<br>35"},
            {key:"G.202" ,label:"G.202<br>35"},
            {key:"G.203" ,label:"G.203<br>35"},
            {key:"G.203A" ,label:"G.203A"},
            {key:"G.203B" ,label:"G.203B"},
            {key:"G.204" ,label:"G.204<br>35"},
            {key:"G.205" ,label:"G.205<br>35"},
            {key:"G.205A" ,label:"G.205A"},
            {key:"G.205B" ,label:"G.205B"},
            {key:"G.301" ,label:"G.301"},
            {key:"G.302" ,label:"G.302"},
            {key:"G.303" ,label:"G.303"},
            {key:"G.304" ,label:"G.304"},
            {key:"G.401" ,label:"G.401<br>40"},
            {key:"G.402" ,label:"G.402<br>40"},
            {key:"G.403" ,label:"G.403<br>40"},
            {key:"G.404" ,label:"G.404<br>40"},
            {key:"G.405" ,label:"G.405<br>40"},
            {key:"H.101" ,label:"H.101<br>35"},
            {key:"H.102" ,label:"H.102<br>40"},
            {key:"H.103" ,label:"H.103<br>40"},
            {key:"H.201" ,label:"H.201<br>30"},
            {key:"H.202" ,label:"H.202<br>30"},
            {key:"H.203" ,label:"H.203<br>30"},
            {key:"H.204" ,label:"H.204<br>40"},
            {key:"H.205" ,label:"H.205<br>40"},
            {key:"H.301" ,label:"H.301<br>30"},
            {key:"H.302" ,label:"H.302<br>30"},
            {key:"H.303" ,label:"H.303<br>30"},
            {key:"H.304" ,label:"H.304<br>40"},
            {key:"H.305" ,label:"H.305<br>40"},
            {key:"H.401" ,label:"H.401<br>30"},
            {key:"H.402" ,label:"H.402<br>30"},
            {key:"H.403" ,label:"H.403<br>30"},
            {key:"H.404" ,label:"H.404<br>40"},
            {key:"H.405" ,label:"H.405<br>40"},
            {key:"H.501" ,label:"H.501<br>40"},
            {key:"H.502" ,label:"H.502<br>40"},
            {key:"H.503" ,label:"H.503<br>40"},
            {key:"H.504" ,label:"H.504<br>40"},
            {key:"M.101" ,label:"M.101<br>40"},
            {key:"M.102" ,label:"M.102<br>40"},
            {key:"M.103" ,label:"M.103<br>40"},
            {key:"M.104" ,label:"M.104<br>35"},
            {key:"M.301" ,label:"M.301<br>35"},
            {key:"M.302" ,label:"M.302<br>30"},
            {key:"M.303" ,label:"M.303<br>40"},
            {key:"M.304" ,label:"M.304<br>40"},
            {key:"N1.301A" ,label:"N1.301A<br>25"},
            {key:"N1.301B" ,label:"N1.301B<br>35"},
            {key:"N1.301C" ,label:"N1.301C<br>35"},
            {key:"N1.302" ,label:"N1.302<br>-"},
            {key:"N1.303" ,label:"N1.303<br>10"},
            {key:"N1.304" ,label:"N1.304<br>35"},
            {key:"N1.305" ,label:"N1.305<br>20"},
            {key:"N1.306" ,label:"N1.306<br>20"},
            {key:"N2.101" ,label:"N2.101<br>-"},
            {key:"N2.102" ,label:"N2.102<br>40"},
            {key:"N2.301" ,label:"N2.301<br>10"},
            {key:"N2.302" ,label:"N2.302<br>35"},
            {key:"N2.303" ,label:"N2.303<br>35"},
            {key:"N2.304" ,label:"N2.304<br>35"},
            {key:"N2.305" ,label:"N2.305<br>35"},
            {key:"N2.306" ,label:"N2.306<br>30"},
            {key:"Gd. Kom Lt 1" ,label:"Gd. Kom Lt 1"},
            {key:"Gd. Kom Lt 3" ,label:"Gd. Kom Lt 3"},
            {key:"Gd. Kom. 303" ,label:"Gd. Kom. 303"},
            {key:"Kom-Cocacola" ,label:"Kom-Cocacola<br>30"},
            {key:"Kom-Fanta" ,label:"Kom-Fanta<br>35"},
            {key:"Kom-Fresty" ,label:"Kom-Fresty<br>30"},
            {key:"Kom-Sprite" ,label:"Kom-Sprite<br>20"},
            {key:"Lab. AV" ,label:"Lab. AV"},
            {key:"B.301" ,label:"B.301"},
            {key:"Lab. MM" ,label:"Lab. MM"},
            {key:"Audito.Kom.", label:"Audito.Kom."},
            {key:"X" ,label:"X"}
        ];

        //color event
        scheduler.templates.event_class = function(start_date, end_date, event) {
            if(event.flag == "1" && event.level == "0") // if event has subject property then special class should be assigned
                return "event_kp";
            if(event.flag == "1" && event.level == "1") // if event has subject property then special class should be assigned
                return "event_1";
            if(event.flag == "1" && event.level == "2") // if event has subject property then special class should be assigned
                return "event_2";
            if(event.flag == "1" && event.level == "3") // if event has subject property then special class should be assigned
                return "event_3";
            return ""; // default return
        };

        scheduler.xy.scale_height = 35;
        scheduler.config.details_on_create=false;
        scheduler.config.details_on_dblclick=false;
        scheduler.config.icons_select = false;
        scheduler.config.xml_date="%Y-%m-%d %H:%i";
        scheduler.config.first_hour = 8;
        scheduler.config.multi_day = true;
        scheduler.locale.labels.unit_tab = "Ruang";
        scheduler.config.fix_tab_position = false;

        scheduler.createUnitsView({
            name:"unit",
            property:"section_id",
            list:sections,
            size:10,
            step:10
        });

        //set tanggal hari ini
        var date = new Date();
        var tahun = date.getFullYear();
        var bulan = date.getMonth();
        var hari = date.getDate();

        scheduler.clearAll();
        scheduler.init('scheduler_here',new Date(tahun, bulan, hari),"unit");
        scheduler.load("<?=base_url()?>peminjaman/schedulerRuangKelas/dataSiak");

        scheduler.addEventNow = function(){
            return null;
        };
    }
</script>