<?php

namespace Nastoletni\Code\Infrastructure;

use Nastoletni\Code\Domain\File;
use Nastoletni\Code\Domain\Paste;
use PHPUnit\Framework\TestCase;

class AES256CrypterTest extends TestCase
{
    /**
     * @dataProvider crypterContentProvider
     */
    public function testCrypter($content)
    {
        $crypter = new AES256Crypter();
        $key = 'test123';

        $paste = new Paste(
            $this->createMock(Paste\Id::class),
            'title',
            new \DateTime()
        );
        $paste->addFile(new File('', $content));

        $encryptedPaste = clone $paste;

        $crypter->encrypt($encryptedPaste, $key);
        $crypter->decrypt($encryptedPaste, $key);

        $this->assertEquals(
            $paste->getFiles()[0]->getContent(),
            $encryptedPaste->getFiles()[0]->getContent()
        );
    }

    public function crypterContentProvider()
    {
        return [
            ['Foobar'],
            [<<<'CONTENT'
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis a facilisis est. Donec bibendum metus ac ex eleifend, eu maximus dolor imperdiet. Donec eget metus magna. Duis et metus erat. Aliquam posuere nisi a orci rutrum, sed molestie dui gravida. Aliquam erat volutpat. Nam a quam in nulla efficitur pulvinar. Phasellus molestie, mauris feugiat volutpat rutrum, erat odio viverra magna, vitae bibendum nisi lectus id sapien.

In blandit urna nibh. Aenean dictum nulla non dapibus aliquam. In non pulvinar urna. Cras eget venenatis massa. Cras rhoncus nisi at ante egestas suscipit. Suspendisse potenti. Suspendisse potenti. Sed vel magna quam.

Sed eu est gravida, suscipit ex a, euismod nibh. In nunc magna, consequat vitae orci et, rutrum malesuada turpis. Cras scelerisque at est ut congue. Cras quis aliquet dolor, et pellentesque nisi. Sed venenatis dapibus ornare. Cras non placerat velit, non sollicitudin justo. Aenean eleifend et dui quis efficitur. In hac habitasse platea dictumst. Integer pulvinar, sapien a facilisis laoreet, tellus ipsum gravida tortor, eu semper libero neque at tellus. Aliquam eleifend nibh vel erat lacinia placerat. Duis quis felis elit. Duis sollicitudin sagittis risus, et consequat enim dictum non. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dui mauris, tincidunt non purus molestie, porta semper mi. Donec placerat tempus nibh, vehicula vulputate turpis commodo eget.

Vivamus finibus gravida lorem, eu sagittis orci tempor in. Quisque vestibulum, arcu quis mollis consectetur, risus mi placerat dolor, at sagittis erat est sit amet lacus. Nulla facilisi. Morbi a ante purus. Suspendisse ultricies dignissim diam, vel egestas nibh eleifend vel. Nulla tempus commodo nunc, at euismod risus pulvinar eget. Cras faucibus nisl porta cursus condimentum.

Nullam sed sodales lectus, vitae porta purus. Phasellus porttitor accumsan diam eget feugiat. Duis sit amet ultricies dui, ut tincidunt ante. Phasellus elit arcu, ullamcorper sed lorem eget, blandit tempus quam. Etiam aliquet mollis nisl, et fringilla magna auctor sit amet. Phasellus iaculis lectus vitae lectus volutpat interdum. Sed condimentum pulvinar tempus. Curabitur eu sagittis neque, ac pharetra neque.

Proin sed accumsan velit, vel dignissim erat. Donec pretium tincidunt metus laoreet semper. Praesent quam dui, lacinia id posuere sed, dictum id arcu. Nunc odio ligula, lacinia a condimentum at, pretium et neque. Ut rhoncus, ante et tristique finibus, magna nunc ornare erat, id ultricies augue lacus eget massa. Morbi massa tortor, tincidunt sit amet erat quis, varius iaculis nisi. Proin lobortis odio eu nisl accumsan posuere. Nam enim enim, sollicitudin vitae odio non, bibendum eleifend erat. Phasellus ligula quam, luctus sagittis lacinia eget, mollis at enim. Nam pulvinar quam est, vitae bibendum odio iaculis pulvinar. Vivamus id justo nibh. Curabitur elementum justo ac venenatis auctor. Vivamus rutrum, nunc nec dapibus bibendum, orci nibh efficitur nulla, ac posuere leo elit quis risus.

Nullam vulputate tortor nec erat condimentum volutpat. Nulla a congue erat, ut bibendum neque. Etiam sem est, porta vitae faucibus quis, tempor nec ligula. Phasellus semper a massa quis lacinia. In mattis ullamcorper lectus vel placerat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Phasellus maximus porta aliquam. Aliquam aliquam molestie posuere. Maecenas eu dolor nec felis molestie pulvinar.

Vivamus mi ex, finibus vel molestie eu, cursus at velit. Morbi consequat turpis lectus, tincidunt hendrerit odio viverra vitae. Donec metus ante, interdum a ullamcorper vitae, molestie sed urna. Proin et viverra neque, vitae faucibus urna. Cras accumsan ac massa eu fringilla. Donec efficitur rutrum diam a tempus. Phasellus at dictum tortor. Duis tempus orci lacus, vehicula finibus tortor cursus a. Nullam mollis tempus tincidunt. Integer fringilla sem in metus dictum sollicitudin.

Nam consectetur euismod mi. Mauris mi leo, lacinia ac quam nec, pretium volutpat turpis. Cras suscipit ullamcorper tincidunt. Curabitur erat elit, tincidunt ut fermentum eget, facilisis ut lorem. Curabitur egestas commodo erat, eget volutpat arcu tincidunt accumsan. Sed lectus erat, finibus vitae vehicula a, posuere eu nisl. Morbi eget ornare massa. Duis vel egestas risus. Maecenas blandit augue quis libero semper cursus. In vitae diam maximus, faucibus risus id, dignissim nisl. Maecenas et erat vel enim efficitur fringilla ut eu augue. Nam viverra, tellus nec sollicitudin rhoncus, ex lacus bibendum justo, et tincidunt ex libero sed eros. Donec tortor diam, blandit sed lobortis ut, blandit sed sapien.

Phasellus blandit cursus lobortis. Vivamus ac cursus lacus. Proin nec felis et lacus tincidunt commodo vel sit amet mauris. Morbi accumsan bibendum mauris. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Fusce odio lacus, pharetra quis augue a, rutrum mollis nisi. In id euismod metus. Morbi sit amet vestibulum lectus. Vivamus quis mi in elit aliquet convallis.

Suspendisse eget volutpat felis. Praesent vel nisl vitae ipsum vulputate blandit. Vivamus ornare sit amet arcu in hendrerit. Nunc vulputate purus sit amet nisi imperdiet, non laoreet sem tempus. Aenean eu quam tristique, elementum orci a, placerat magna. Maecenas et dictum massa. Vestibulum viverra, purus pharetra dapibus euismod, libero tortor lobortis sem, non sagittis urna tortor ac nisi. In ligula nisl, faucibus ut nulla vitae, pulvinar ullamcorper mi. Ut vel risus diam. Nulla vel placerat elit.

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin auctor, velit eget varius finibus, ligula massa dignissim nisl, eu ornare nunc sem hendrerit arcu. Proin venenatis interdum neque, id fermentum justo aliquam at. Vivamus nec nisl viverra, tempor mi ut, rhoncus libero. Aliquam sed facilisis urna. Quisque vel odio id metus porta vulputate non in libero. Etiam non suscipit ligula.

Suspendisse vehicula turpis semper risus dictum, eget tempus ligula fermentum. Aliquam erat volutpat. Suspendisse sed massa quis velit egestas pretium. Vestibulum rutrum, ligula at accumsan hendrerit, quam nunc fermentum magna, vitae vestibulum diam nulla non nulla. Suspendisse et dui velit. Fusce risus felis, mollis at nulla ac, consectetur venenatis diam. Sed lobortis lorem id vestibulum malesuada.

Aliquam neque urna, interdum vitae tortor nec, dictum sodales risus. Cras risus magna, ullamcorper vitae libero non, pellentesque bibendum nisl. Vivamus aliquet nulla in augue consequat, at porta augue euismod. Curabitur finibus tincidunt bibendum. Suspendisse potenti. In hac habitasse platea dictumst. Suspendisse quam enim, dignissim eget dolor eu, consequat lobortis est.

Etiam rutrum arcu ac dapibus egestas. Vestibulum a mi vel purus faucibus tempor. Maecenas varius elit vel elementum bibendum. Ut eget lectus eu neque dictum vehicula eget sit amet magna. Proin at erat tincidunt, lacinia velit a, auctor mi. Mauris a sem eu eros mattis suscipit porta nec odio. Nam at ligula pharetra, elementum magna vitae, fringilla sapien. Nunc consequat enim in massa consectetur efficitur. Phasellus scelerisque eros at dui suscipit, nec bibendum lectus congue. Fusce bibendum enim at diam posuere, quis laoreet dolor pulvinar. Quisque enim enim, placerat auctor dui non, scelerisque auctor turpis. Quisque iaculis felis vitae mauris dictum, eget lobortis nisl tincidunt. Nulla dapibus felis quis eros euismod porttitor.

Donec gravida augue in ipsum convallis viverra. Nunc suscipit nunc et diam euismod aliquam viverra non lacus. Aliquam erat volutpat. Mauris semper justo a tincidunt dapibus. Nam eget eleifend nisl. Nulla feugiat, risus vel tempus eleifend, elit nisi convallis est, sit amet feugiat dui lectus sit amet dolor. Nunc eget eros erat.

Suspendisse potenti. Duis consequat dolor facilisis arcu facilisis, sed maximus erat pulvinar. Nullam faucibus sem nec justo efficitur fringilla. Ut rhoncus vitae metus et blandit. Phasellus tempor mauris sit amet laoreet elementum. Vivamus eu arcu aliquam, aliquet dolor a, aliquam libero. Donec nec lorem velit. Nullam hendrerit turpis et mauris rhoncus hendrerit sit amet at dolor. Curabitur et urna imperdiet, laoreet libero at, tristique dolor.

Quisque aliquam dignissim cursus. Sed eget tincidunt justo. Praesent pharetra facilisis sem in ullamcorper. Praesent mollis orci in lorem consequat convallis. Nulla ultrices sit amet lorem vitae fringilla. Phasellus dignissim auctor enim, vitae iaculis justo pretium non. Donec tempor diam commodo metus vulputate, ac volutpat purus efficitur. Etiam sit amet orci ut elit lobortis semper vel vel tortor. Phasellus molestie, nunc id euismod cursus, arcu turpis varius enim, eu tincidunt nisl massa et massa. Maecenas pulvinar odio dui, ut laoreet nisl porta non.

Vivamus lobortis, odio vitae fringilla posuere, odio purus pharetra magna, ornare dapibus ipsum lectus sit amet ligula. Sed placerat urna non orci volutpat pellentesque. Aenean non tempus orci. Mauris sodales laoreet risus, vitae aliquet elit bibendum pellentesque. Sed ullamcorper laoreet venenatis. Fusce tortor dolor, egestas sit amet ullamcorper ut, malesuada in est. Proin lorem nibh, interdum et diam vitae, elementum feugiat lectus. Vivamus venenatis augue id risus mattis mollis. Mauris sit amet quam felis. Suspendisse potenti. Etiam euismod quam sit amet sapien ornare, a imperdiet massa eleifend. Nulla laoreet libero massa, eget vestibulum justo egestas eu. Nulla facilisi. Nam eu lorem vel orci maximus elementum sit amet auctor massa. Donec ut laoreet libero. Sed a velit ipsum.

Nam urna mauris, elementum sit amet sapien eu, euismod pharetra dolor. Etiam sed sem sapien. Mauris eu scelerisque orci. Curabitur lobortis magna a ligula malesuada, eu aliquam justo euismod. Phasellus vel blandit est. Morbi pretium, nisi non condimentum gravida, orci elit mollis neque, in condimentum leo quam at nunc. Nulla aliquam pretium mauris eu condimentum. Nulla convallis sed dui sed facilisis. Morbi at metus viverra, consequat erat quis, euismod mi. Praesent in bibendum ante. In in purus tellus. Nunc est enim, volutpat sed mauris sit amet, cursus molestie urna. Donec dictum nisi id massa porttitor scelerisque sed.
CONTENT
]
        ];
    }
}
