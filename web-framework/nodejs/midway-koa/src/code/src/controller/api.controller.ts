import { Inject, Controller, Post, Body } from '@midwayjs/decorator';
import { Context } from '@midwayjs/koa';
import { Iteration } from '../interface';
import { IterationService } from '../service/iteration.service';

@Controller('/api/workbench/iteration')
export class APIController {
  @Inject()
  ctx: Context;

  @Inject()
  iterationService: IterationService;

  // 新建迭代
  @Post('/create')
  async createIteration(@Body() iteration: Iteration) {
    console.log(iteration);
    // const user = await this.iterationService.createIteration({ uid });
    return { success: true, message: 'OK', data: iteration };
  }
}
