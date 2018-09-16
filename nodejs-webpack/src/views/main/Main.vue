<template>
  <main>
    <el-row :gutter="10">
      <el-col :span="16">
        <div class="left">
          <el-card class="card">
            <div slot="header">
              <cardhead title="流程图"></cardhead>
            </div>
            <v-table :tableData="liucheng.tableData" :tableHead="liucheng.tableHead"></v-table>
          </el-card>

          <el-card class="card">
            <div slot="header">
              <cardhead title="未关闭的产品"></cardhead>
            </div>
            <v-table :tableData="noShutDown.tableData" :tableHead="noShutDown.tableHead"></v-table>
          </el-card>

          <el-card class="card">
            <div slot="header">
              <cardhead title="进行中的产品"></cardhead>
            </div>
            <v-table :tableData="working.tableData" :tableHead="working.tableHead"></v-table>
          </el-card>
        </div>
      </el-col>
      <el-col :span="8">
        <div class="right">
          右边
        </div>
      </el-col>
    </el-row>
  </main>
</template>

<script>
import cardhead from '../../components/cardhead/cardhead'
import table from '../../components/table/table'

export default {
  name: "Main",
  data () {
    return {
      liucheng: {
        tableData: [{
          character: '产品经理',
          step1: '创建产品',
          step2: '维护模块',
          step3: '维护计划',
          step4: '维护需求',
          step5: '创建发布'
        }, {
          character: '产品经理',
          step1: '创建产品',
          step2: '维护模块',
          step3: '维护计划',
          step4: '维护需求',
          step5: '创建发布'
        }, {
          character: '产品经理',
          step1: '创建产品',
          step2: '维护模块',
          step3: '维护计划',
          step4: '维护需求',
          step5: '创建发布'
        }],
        tableHead: ['角色', '步骤一', '步骤二', '步骤三', '步骤四', '步骤五']
      },
      noShutDown: {
        tableData: [{
          name: '企业内部工时管理系统',
          current: '测试2018',
          project: '0',
          publish: '1',
          active: '0',
          bug: '1'
        }, {
          name: '公司企业网站建设',
          current: 'tets',
          project: '0',
          publish: '1',
          active: '0',
          bug: '1'
        }],
        tableHead: ['产品名称', '当前项目', '计划数', '发布数', '激活需求', '未解决Bug']
      },
      working: {
        tableData: [{
          name: 'test',
          current: '2018-01-01',
          project: '0',
          publish: '1',
          active: '0',
          bug: '123'
        }, {
          name: '321',
          current: '2018-09-01',
          project: '021',
          publish: '123',
          active: '03',
          bug: '12'
        }],
        tableHead: ['项目名称', '截止日期', '状态', '预计', '消耗', '剩余']
      }
    }
  },
  components: {
    cardhead,
    'v-table': table
  }
}
</script>

<style lang="scss" scoped>
.card {
  margin-top: 20px;
}
</style>
