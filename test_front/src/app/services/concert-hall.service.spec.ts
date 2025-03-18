import { TestBed } from '@angular/core/testing';

import { ConcertHallService } from './concert-hall.service';

describe('ConcertHallService', () => {
  let service: ConcertHallService;

  beforeEach(() => {
    TestBed.configureTestingModule({});
    service = TestBed.inject(ConcertHallService);
  });

  it('should be created', () => {
    expect(service).toBeTruthy();
  });
});
