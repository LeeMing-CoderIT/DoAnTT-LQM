<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('stories')->insert([
            [
                'author' => 'Thâm Bích Sắc',
                'name' => 'Nàng Không Muốn Làm Hoàng Hậu',
                'slug' => 'nang-khong-muon-lam-hoang-hau',
                'image' => 'nang_khong_muon_lam_hoang_hau.jpg',
                'description' => 'Phụ mẫu Vân Kiều mất sớm, một mình nàng tự buôn bán nhỏ, còn nhặt được một thư sinh nghèo mi thanh mục tú về làm phu quân, mỗi ngày trôi qua cũng có chút thú vị.<br><br>Sau này, khi phu quân nàng vào kinh đi thi, hắn bỗng nhiên trở thành Thái tử tôn quý.<br><br>Ai ai cũng đều nói Vân Kiều nàng có phúc, ấy vậy mà lại được gả cho hoàng tử lưu lạc ở dân gian. Song, Vân Kiều lại cảm thấy vô cùng hụt hẫng.<br><br>Nàng không quen với cuộc sống cẩm y ngọc thực, cũng không am hiểu cầm kỳ thi hoạ, phong hoa tuyết nguyệt, thậm chí chữ viết cũng rất xấu. Hoa phục của Trung cung mặc lên người nàng không hề giống một Hoàng Hậu.<br><br>Vân Kiều cẩn tuân lời dạy bảo của Thái hậu, học quy củ, tuân thủ lễ nghi, không sân si, không đố kị, mãi đến khi Bùi Thừa Tư tìm được bạch nguyệt quang trong lòng hắn. Cuối cùng, nàng mới hiểu, hoá ra Bùi Thừa Tư cũng có thể yêu một người đến vậy.<br><br>Ngày Bùi Thừa Tư sửa tên đổi họ cho bạch nguyệt quang đã mất phu quân kia, cho nàng ta tiến cung phong phi, Vân Kiều uống chén thuốc ph* thai làm mất đi hài tử mà chính nàng đã mong đợi.<br><br>Đối mặt với cơn giận lôi đình của Bùi Thừa Tư, nàng không màng đến vị trí Hoàng hậu, nàng muốn về lại trấn Quế Hoa.<br><br>Nàng ghét phải nhìn bầu trời nhỏ hẹp trong cung cấm, nàng muốn trở về thị trấn nhỏ, thiên hạ rộng lớn, hương thơm tỏa khắp đất trời vào cuối thu.<br><br>Nàng cũng ghét nhìn thấy Bùi Thừa Tư.<br><br>Từ đầu tới cuối, nàng chỉ yêu chàng thư sinh áo xanh phóng khoáng nọ, chỉ cần nhìn thoáng qua cũng thấy yêu thích vô cùng. Tiếc là, từ lúc hắn rời trấn vào kinh, hắn đã chết rồi.<br><br>Vai chính: Vân Kiều ┃ vai phụ: Những người còn lại.<br><br>Lập ý: Nếu ngươi vô tình vậy thì ta sẽ hưu.',
                'categories' => json_encode([1,2], JSON_UNESCAPED_UNICODE),
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'author' => 'Nam Phi Nhất Khách',
                'name' => 'Trở Về Niên Đại: Mang Theo Hệ Thống Đánh Dấu Làm Giàu',
                'slug' => 'tro-ve-nien-dai:-mang-theo-he-thong-danh-dau-lam-giau',
                'image' => 'tro-ve-nien-dai-mang-theo-he-thong-danh-dau-lam-giau.jpg',
                'description' => 'Văn án<br><br>Phòng thí nghiệm nổ mạnh làm Lâm Đường trở về cái niên đại nghèo khó thiếu thốn vật tư kia, còn buộc chặt với một cái hệ thống đánh dấu.<br><br>Cô còn chưa kịp lấy món quà của người mới thì vị hôn phu được định ra từ bé đã chạy tới cửa từ hôn.<br><br>Nguyên nhân từ hôn là vì hắn sắp trở thành công nhân, đi vào thành phố làm việc.<br><br>Lâm Đường nhìn người nam nhân có khuôn mặt bình thường mà lại tỏ ra rất tự tin kia, môi đỏ hé mở: “…… Được!”<br><br>Chưa tới một tháng, vị hôn phu bị đuổi việc.<br><br>Lâm Đường đi dạo quanh huyện một vòng liền trở thành cán bộ của xưởng dệt.<br><br>Nội tâm của vị hôn phu: Hiện tại cầu hợp lại còn kịp sao?<br><br>Cái niên đại này thật sự rất quá thiếu thốn vật tư rồi.<br><br>Tuy rằng được ba người anh và cha mẹ yêu chiều, nhưng ăn cơm cần có phiếu gạo, mua vải cần có phiếu vải, mua thịt cần phiếu thịt, thậm chí ngay cả mua một phối xà bông cũng cần có phiếu....<br><br>Cho dù thắt chặt lưng quần để sinh hoạt thì vẫn vô cùng khó khăn.<br><br>Nhìn thứ đen sì sì trong chén, Lâm Đường im lặng: “……” <br><br>May mà cô có một cái hệ thống! <br><br>Muốn cái gì? Chỉ cần đánh dấu là sẽ có.<br><br>Nhiều năm sau.<br><br>Người nam nhân tuấn mỹ nào đó nhìn người vợ yếu đuối mong manh, khuôn mặt nhỏ trắng nõn, cố gắng không thay đổi sắc mặt hỏi: “Nghe nói năm đó em đánh hai đấm đã hạ gục một con lợn rừng?”<br><br>Ánh mắt Lâm Đường hơi lóe lên, đầu ngón tay hơi dùng một chút lực thì cái chén sứ tráng men trong tay liền biến hình, nghiêm túc nói: “Nào có? Anh đừng nghe mấy người đó nói hươu nói vượn, chúng ta đều là người làm công tác văn hoá, sao có thể bạo lực như vậy được!”',
                'categories' => json_encode([1], JSON_UNESCAPED_UNICODE),
                'status' => 0,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        ]);
    }
}
