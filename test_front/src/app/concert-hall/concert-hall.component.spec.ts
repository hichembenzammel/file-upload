import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ConcertHallComponent } from './concert-hall.component';

describe('ConcertHallComponent', () => {
  let component: ConcertHallComponent;
  let fixture: ComponentFixture<ConcertHallComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      imports: [ConcertHallComponent]
    })
    .compileComponents();
    
    fixture = TestBed.createComponent(ConcertHallComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
