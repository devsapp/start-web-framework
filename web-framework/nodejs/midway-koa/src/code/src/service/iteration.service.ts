import { Provide } from '@midwayjs/decorator';
import { IterationOptions } from '../interface';

@Provide()
export class IterationService {
  async createIteration(options: IterationOptions) {
    return {
      uid: options.uid,
      username: 'mockedName',
      phone: '12345678901',
      email: 'xxx.xxx@xxx.com',
    };
  }
}
