# Discover 项目文档
## 1. 基本介绍
### 1.0 项目介绍
Discover 是基于开发语言 `PHP7.3`，`Laravel` 框架开发。项目中采用的拓展如下：
* [dcat/laravel-admin](https://github.com/jqhph/dcat-admin)
* [overtrue/laravel-pinyin](https://github.com/overtrue/laravel-pinyin)
* [propaganistas/laravel-phone](https://github.com/Propaganistas/Laravel-Phone)
* [spatie/laravel-enum](https://github.com/spatie/laravel-enum)
* [yxx/laravel-quick](https://github.com/youyingxiang/laravel-quick)
* [zgldh/qiniu-laravel-storage](https://github.com/overtrue/laravel-filesystem-qiniu)

### 1.1 适用场景
生产加工羽绒，羽毛制品的厂家。

### 1.2 安装

* [Github 地址](https://github.com/youyingxiang/Discover), [gitee 地址](https://gitee.com/dcat-phper/discover)
* 执行 `composer install`  
* 将 `.env.example` 复制重命名为 `.env`, 并在 `.env` 设置数据库账号密码等信息。
* 执行 `php artisan migrate` 生成表结构。
* 执行 `php artisan db:seed --class=InitSeeder` 初始化数据库。

### 1.3 技术交流

QQ群：1129427935



## 2. 采购管理
供应商档案->采购订购->采购入库
### 2.0 采购订购
采购订购是做采购预定，并不是实际入库

所有订单双击所在行即可编辑。

![image](https://user-images.githubusercontent.com/74885727/121763740-f4df9080-cb70-11eb-94de-3b68d8ff14ff.png)

采购订单审核时候,采购数量必须大于0。

![image](https://user-images.githubusercontent.com/74885727/121763791-4556ee00-cb71-11eb-93e2-db00c3ff1792.png)

修改订单明细之后，鼠标离开焦点即完成修改。

![image](https://user-images.githubusercontent.com/74885727/121763838-99fa6900-cb71-11eb-9676-4a8e75df1131.png)
![image](https://user-images.githubusercontent.com/74885727/121763870-cdd58e80-cb71-11eb-8372-620f9c230ce1.png)

### 2.1 采购入库
采购入库是对订单进行入库操作

选择已经审核的采购订购单。

![image](https://user-images.githubusercontent.com/74885727/121763927-48061300-cb72-11eb-9da2-f305e77a6cd7.png)
![image](https://user-images.githubusercontent.com/74885727/121763937-623ff100-cb72-11eb-8b69-5685e3244ef9.png)

生产采购入库单会自动生产年月日的批次号，同时可以对入库明细进行调整。

![image](https://user-images.githubusercontent.com/74885727/121763971-9e735180-cb72-11eb-967b-6e9da517a6fb.png)
## 3. 库存管理
### 3.0 产品库存
产品库存是产品名称，类型，属性，含绒量，检验标准完全一样的为一个产品。

![image](https://user-images.githubusercontent.com/74885727/121764023-1d688a00-cb73-11eb-9111-811a1466d7c3.png)
### 3.1 批次库存
产品库存展开可以看到批次库存，批次库存是产品名称，类型，属性，含绒量，检验标准完全一样的产品，但是入库有多个批次，比如2021-05-21入库一笔
，2021-05-22 入库一笔，那这个产品就有两个批次号。

![image](https://user-images.githubusercontent.com/74885727/121764053-6e787e00-cb73-11eb-97dc-9ab9d8f7704a.png)

除了产品库存展开可以看到批次库存，我们还有专门的批次库存报表。

![image](https://user-images.githubusercontent.com/74885727/121764102-da5ae680-cb73-11eb-9070-8cea2205c3b8.png)

### 3.2 产品检验
采购的产品现在入库了，当时填的含绒量不一定准确，这时候我将仓库的产品抽样送检，检查实际含绒量，并填好检验的标准。

![image](https://user-images.githubusercontent.com/74885727/121764155-4fc6b700-cb74-11eb-9182-4c1e2c5c4ea1.png)

### 3.3 仓库库位
在采购入库的时候会让选择一个仓库库位。自己查询库存的时候，可以知道对应的货物放到哪个位置的。

![image](https://user-images.githubusercontent.com/74885727/121764193-a46a3200-cb74-11eb-9767-333df2c43dcc.png)

### 3.4 库存往来
仓库货物的每一笔出入库记录。

![image](https://user-images.githubusercontent.com/74885727/121764231-09258c80-cb75-11eb-8572-c6256b9ddbd5.png)

### 3.5 期初建账
在第一次使用软件的时候，仓库有库存，这笔库存可以做期初录入进去。

![image](https://user-images.githubusercontent.com/74885727/121764257-3d00b200-cb75-11eb-9b59-ea9ce9292e4c.png)

## 4. 销售管理
客户档案->客户要货单->客户出货单

### 4.0 客户要货单
企业的客户需要一批货物,这时候销售可以做一笔客户要货单。

![image](https://user-images.githubusercontent.com/74885727/121764388-142cec80-cb76-11eb-88d0-56652911297d.png)

### 4.1 客户出货单
库管选择审核通过的要货单进行出库。

![image](https://user-images.githubusercontent.com/74885727/121764476-c95fa480-cb76-11eb-8cea-c9c586477c3c.png)

点开批次详情，选择出库的批次。

![image](https://user-images.githubusercontent.com/74885727/121764491-f6ac5280-cb76-11eb-88fb-d49b0e1c4737.png)

出库的产品一定要有库存，否则选不到对应的库存出库。

![image](https://user-images.githubusercontent.com/74885727/121764522-2bb8a500-cb77-11eb-809c-719c4e252c2a.png)

输入要出库对应批次的数量。

![image](https://user-images.githubusercontent.com/74885727/121764542-4e4abe00-cb77-11eb-812d-1d30ebee15b5.png)

审核即可完成出库。

![image](https://user-images.githubusercontent.com/74885727/121764588-b00b2800-cb77-11eb-80fc-73a26109c225.png)

## 5. 生产加工
生产任务->物料申领->生产入库

### 5.0 生产工艺
添加生产工艺

![image](https://user-images.githubusercontent.com/74885727/121764712-83a3db80-cb78-11eb-9e9a-62cd8bfd1906.png)

### 5.1 生产任务

添加需要生产加工的任务

![image](https://user-images.githubusercontent.com/74885727/121764744-b3eb7a00-cb78-11eb-8a35-1da357dc3314.png)


生产任务进行物料申领

![image](https://user-images.githubusercontent.com/74885727/121764763-e1d0be80-cb78-11eb-9bfa-f2864f6b4999.png)

![image](https://user-images.githubusercontent.com/74885727/121764773-f7de7f00-cb78-11eb-8194-0a80ebe19d3e.png)

对生产的物料申领单进行审核

![image](https://user-images.githubusercontent.com/74885727/121764792-22303c80-cb79-11eb-8d19-0e11ee572f08.png)

只有生产任务其下所有物料申领单完成审核，才可以进行生产入库。当生产任务所有物料申领单审核以后，生产任务状态会变为已领料。

![image](https://user-images.githubusercontent.com/74885727/121764832-75a28a80-cb79-11eb-8ad7-23f684087d63.png)

审核生产入库单，生产入库边完成。生产入库的成本价格 = 物料申领的总成本价格 % 生产入库的数量。

![image](https://user-images.githubusercontent.com/74885727/121764862-b3071800-cb79-11eb-9405-4305a106a6a9.png)

## 6. 盘点管理
盘点是指定期或临时对库存商品实际数量进行清查、清点的一种作业。

### 6.0 盘点任务
建立好盘点任务后，当进入盘点时间范围以后，盘点任务会自动变为盘点中。

![image](https://user-images.githubusercontent.com/74885727/121764987-7a1b7300-cb7a-11eb-9920-0a05e1942cda.png)

![image](https://user-images.githubusercontent.com/74885727/121765160-8b18b400-cb7b-11eb-8ee8-a9080a896b9a.png)

当有状态为盘点中的任务，我们是无法进行任何订单审核的。

![image](https://user-images.githubusercontent.com/74885727/121765133-5efd3300-cb7b-11eb-8a1a-aeb9943e9da7.png)

### 6.1 盘点单据
选择要盘点的数据

![image](https://user-images.githubusercontent.com/74885727/121765203-cd41f580-cb7b-11eb-8467-90059fe98f2f.png)

![image](https://user-images.githubusercontent.com/74885727/121765218-f2366880-cb7b-11eb-9630-0cad303c40f7.png)

输入实盘数量，审核单据完成盘点。

![image](https://user-images.githubusercontent.com/74885727/121765246-1e51e980-cb7c-11eb-9ea1-163a696c9d1d.png)

可以删除状态非已完成的盘点数据

![image](https://user-images.githubusercontent.com/74885727/121765302-70930a80-cb7c-11eb-924b-369fef9393f1.png)

## 7. 财务管理
### 7.0 会计期
自然月是每个月1号开始,每个月月底结束。

![image](https://user-images.githubusercontent.com/74885727/121765355-e13a2700-cb7c-11eb-95c7-0e80d0a52702.png)

同时也可以自定义，我这里自定义结算日为28日。

![image](https://user-images.githubusercontent.com/74885727/121765396-1a729700-cb7d-11eb-983d-2aa363f74e6a.png)

生成的会计期如下：

![image](https://user-images.githubusercontent.com/74885727/121765420-455ceb00-cb7d-11eb-92bb-74731ecc3f54.png)

### 7.1 月结

当月只能对当月之前的月份进行月结（比如当月是2021年6月，只能对2021年5月，2021年4月，2021年3月。。。。）进行月结。

![image](https://user-images.githubusercontent.com/74885727/121765498-cc11c800-cb7d-11eb-94b8-a82ffc78fe76.png)

### 7.2  费用单
月结以后生成费用单。月结不会重复生成费用单，一个(客户/供应商)一个月份只会生成一笔费用单。

![image](https://user-images.githubusercontent.com/74885727/121765525-f8c5df80-cb7d-11eb-82ff-721179d02662.png)

![image](https://user-images.githubusercontent.com/74885727/121765567-6a9e2900-cb7e-11eb-8fba-a7a0853f03ac.png)

### 结算单
选择已经审核的费用单进行结算。一笔费用单可以多次结算。

![image](https://user-images.githubusercontent.com/74885727/121765597-a3d69900-cb7e-11eb-84a2-aeabe5210352.png)

![image](https://user-images.githubusercontent.com/74885727/121765603-bcdf4a00-cb7e-11eb-8e79-7f9bff31a6e4.png)

已付款金额+已优惠大于等于订单金额的时候，该笔费用单已经付清。

![image](https://user-images.githubusercontent.com/74885727/121765617-d41e3780-cb7e-11eb-9d9b-1bbd5d4998e1.png)

## 报表中心

![image](https://user-images.githubusercontent.com/74885727/121765659-1a739680-cb7f-11eb-86ee-8e04b11981f2.png)
