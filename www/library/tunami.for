C   ************************************ TUNAMI ************************************
C
C     Tohoku University Numerical Analysis Model for Investigation of tsunamis
C     
C
C	This program includes far-field tsunami simulation in 
C	the spherical coordinate system and near-field tsunami
C	tsunami simulation in the cartesian coordinate system using
C	the nonlinear long-wave theory with runup computation.
C
C
C	Written by: Dr. Anat Ruangrassamee
C				Chulalongkorn University
C				at Tohoku University
C
C	Last Update by: Nopporn Saelem
C				Chulalongkorn University
C				at Chulalongkorn University
C
C	Update history
C	------------------------------------------------------------------------------
C		Date					By						Description					
C	------------------------------------------------------------------------------
C	  7-8 July 2005		Anat Ruangrassamee		Development of the program
C	    9 July 2005		Anat Ruangrassamee		Add the spherical coordinate system for Region No. 1
C	   11 July 2005		Anat Ruangrassamee		Revise the program for spherical coordinate system and include different time step sizes.
C	   13 July 2005		Anat Ruangrassamee		Check the program
C	   14 July 2005		Anat Ruangrassamee		Add JNQ_S2C and interpolation in time/ Correct the computation in the spherical coordinate system
C	   15 July 2005		Anat Ruangrassamee		Final check
C	   16 July 2005		Anat Ruangrassamee		Correct the part for outputting Z and the subroutine PARAME
C	   22 July 2005		Anat Ruangrassamee		Add OUTM OUTN POINTZ MAXZ
C	   23 July 2005		Anat Ruangrassamee		Add Tide in the analysis
C	    1 June 2006		Nopporn Saelem   		Revise subroutine PARAME,CF,MASS,OPENBOUNDARY,MOMENT
C	    5 June 2006		Nopporn Saelem   		Revise subroutine PARAME,CF,MASS,OPENBOUNDARY,MOMENT and OUT Z
C
C	------------------------------------------------------------------------------
C
C	Unit
C	Length	= meter
C	Time	= second
C
C
C	Definition of Parameters in Main Program
C	------------------------------------------------------------------------------
C		Name	Dimension		Description					
C	------------------------------------------------------------------------------
C		DT		1				Time step size 
C		NT		1				Number of time steps
C		FMS		1				Manning's coefficient in the sea
C		FML		1				Manning's coefficient on the land
C		G		1				Gravitational acceleration (9.81 m/s**2)
C		TIDE	1				Tidal height from the mean sea level
C
C		For Region No. 1
C
C		IF1		1				The dimension of data in the X direction
C		JF1		1				The dimension of data in the Y direction
C		Z1		IF x JF	x 2		The vertical displacement of water surface above the still water lavel
C		HZ1		IF x JF	x 1		Still water depth
C		DZ1		IF x JF	x 2		Total water depth		
C		M1		IF x JF	x 2		Water discharge in the X direction
C		N1		IF x JF	x 2		Water discharge in the Y direction
C		HM1		IF x JF	x 1		Still water depth at the point of water dischage in the X direction
C		HN1		IF x JF	x 1		Still water depth at the point of water dischage in the Y direction
C		DM1		IF x JF	x 2		Total water depth at the point of water dischage in the X direction
C		DN1		IF x JF	x 2		Total water depth at the point of water dischage in the Y direction
C		DX1		1				Grid size
C		R1		1				DT/DX1
C		L12		4				The location of the origin of Region 2 on Region 1 
C								L12(1)=X at the lower left corner,  L12(2)=Y at the lower left corner, 
C								L12(3)=X at the upper right corner, L12(4)=Y at the upper right corner
C		TH1		1				The threshold for computing the land. 
C								If TH1=0.0, computation is not done on the land.
C								If TH1=-A, computation will be done up to the land elevation of A.
C
C		For Region No. 2
C
C		IF2		1				The dimension of data in the X direction
C		JF2		1				The dimension of data in the Y direction
C		Z2		IF x JF	x 2		The vertical displacement of water surface above the still water lavel
C		HZ2		IF x JF	x 1		Still water depth
C		DZ2		IF x JF	x 2		Total water depth		
C		M2		IF x JF	x 2		Water discharge in the X direction
C		N2		IF x JF	x 2		Water discharge in the Y direction
C		HM2		IF x JF	x 1		Still water depth at the point of water dischage in the X direction
C		HN2		IF x JF	x 1		Still water depth at the point of water dischage in the Y direction
C		DM2		IF x JF	x 2		Total water depth at the point of water dischage in the X direction
C		DN2		IF x JF	x 2		Total water depth at the point of water dischage in the Y direction
C		DX2		1				Grid size
C		R2		1				DT/DX2
C		L23		4				The location of the origin of Region 3 on Region 2 
C								L23(1)=X at the lower left corner,  L23(2)=Y at the lower left corner, 
C								L23(3)=X at the upper right corner, L23(4)=Y at the upper right corner
C		TH2		1				The threshold for computing the land. 
C								If TH2=0.0, computation is not done on the land.
C								If TH2=-A, computation will be done up to the land elevation of A.
C
C		For Region No. 3
C
C		IF3		1				The dimension of data in the X direction
C		JF3		1				The dimension of data in the Y direction
C		Z3		IF x JF	x 2		The vertical displacement of water surface above the still water lavel
C		HZ3		IF x JF	x 1		Still water depth
C		DZ3		IF x JF	x 2		Total water depth		
C		M3		IF x JF	x 2		Water discharge in the X direction
C		N3		IF x JF	x 2		Water discharge in the Y direction
C		HM3		IF x JF	x 1		Still water depth at the point of water dischage in the X direction
C		HN3		IF x JF	x 1		Still water depth at the point of water dischage in the Y direction
C		DM3		IF x JF	x 2		Total water depth at the point of water dischage in the X direction
C		DN3		IF x JF	x 2		Total water depth at the point of water dischage in the Y direction
C		DX3		1				Grid size
C		R3		1				DT/DX3
C		L34		4				The location of the origin of Region 4 on Region 3 
C								L34(1)=X at the lower left corner,  L34(2)=Y at the lower left corner, 
C								L34(3)=X at the upper right corner, L34(4)=Y at the upper right corner
C		TH3		1				The threshold for computing the land. 
C								If TH3=0.0, computation is not done on the land.
C								If TH3=-A, computation will be done up to the land elevation of A.
C
C		For Region No. 4
C
C		IF4		1				The dimension of data in the X direction
C		JF4		1				The dimension of data in the Y direction
C		Z4		IF x JF	x 2		The vertical displacement of water surface above the still water lavel
C		HZ4		IF x JF	x 1		Still water depth
C		DZ4		IF x JF	x 2		Total water depth		
C		M4		IF x JF	x 2		Water discharge in the X direction
C		N4		IF x JF	x 2		Water discharge in the Y direction
C		HM4		IF x JF	x 1		Still water depth at the point of water dischage in the X direction
C		HN4		IF x JF	x 1		Still water depth at the point of water dischage in the Y direction
C		DM4		IF x JF	x 2		Total water depth at the point of water dischage in the X direction
C		DN4		IF x JF	x 2		Total water depth at the point of water dischage in the Y direction
C		DX4		1				Grid size
C		R4		1				DT/DX4
C		TH4		1				The threshold for computing the land. 
C								If TH4=0.0, computation is not done on the land.
C								If TH4=-A, computation will be done up to the land elevation of A.
C
C
C	------------------------------------------------------------------------------
C	Parameter settings
C
C	{START_STATIC}
	PARAMETER (IF1=__IF1__, JF1=__JF1__, DS1=__DS1__)
	PARAMETER (IF2=__IF2__, JF2=__JF2__, DX2=__DX2__, TH2=__TH2__)
	PARAMETER (IF3=__IF3__, JF3=__JF3__, DX3=__DX3__, TH3=__TH3__)
	PARAMETER (IF4=__IF4__, JF4=__JF4__, DX4=__DX4__, TH4=__TH4__)
	PARAMETER (DT1=__DT1__, DT=__DT__, NT1=__NT1__, NT2=__NT2__, FM=__FM__)
C     ***** ADD NF, NUMBER OF FAULT *****
C     ***** ADD NR, RT/DRT *****   
 	PARAMETER (NF=__NF__, NR=__NR__)
C     **** ADD ****
	PARAMETER (GX=__GX__, GX1=__GX1__, GG=__GG__)
	PARAMETER (NDP1=__NDP1__, NDP2=__NDP2__)
	PARAMETER (NDP3=__NDP3__, NDP4=__NDP4__, NTP=__NTP__, KP=__KP__)
	PARAMETER (XG=__XG__, YG=__YG__)
	PARAMETER (NP1=__NP1__, NP2=__NP2__, NP3=__NP3__, NP4=__NP4__)
	PARAMETER (TIDE=__TIDE__)
	INTEGER, PARAMETER :: ROWF=__ROWF__, COLF=__COLF__
C	{END_STATIC}
C	Parameter declaration
C	START_TAG_PARAM_DECLARE
	REAL Z1(IF1,JF1,2), HZ1(IF1,JF1), DZ1(IF1,JF1,2)
	REAL M1(IF1,JF1,2), N1(IF1,JF1,2) 
	REAL M1T(IF1,JF1,2),N1T(IF1,JF1,2)
C
	REAL Z2(IF2,JF2,2), HZ2(IF2,JF2), DZ2(IF2,JF2,2)
	REAL M2(IF2,JF2,2), HM2(IF2,JF2), DM2(IF2,JF2,2)
	REAL N2(IF2,JF2,2), HN2(IF2,JF2), DN2(IF2,JF2,2)
C
	REAL Z3(IF3,JF3,2), HZ3(IF3,JF3), DZ3(IF3,JF3,2)
	REAL M3(IF3,JF3,2), HM3(IF3,JF3), DM3(IF3,JF3,2)
	REAL N3(IF3,JF3,2), HN3(IF3,JF3), DN3(IF3,JF3,2)
C
	REAL Z4(IF4,JF4,2), HZ4(IF4,JF4), DZ4(IF4,JF4,2)
	REAL M4(IF4,JF4,2), HM4(IF4,JF4), DM4(IF4,JF4,2)
	REAL N4(IF4,JF4,2), HN4(IF4,JF4), DN4(IF4,JF4,2)
C
	REAL ZM1(IF1,JF1),ZM2(IF2,JF2),ZM3(IF3,JF3),ZM4(IF4,JF4)
	REAL MM1(IF1,JF1),MM2(IF2,JF2),MM3(IF3,JF3),MM4(IF4,JF4)
	REAL NM1(IF1,JF1),NM2(IF2,JF2),NM3(IF3,JF3),NM4(IF4,JF4)
	REAL ZMN1(IF1,JF1),ZMN2(IF2,JF2),ZMN3(IF3,JF3),ZMN4(IF4,JF4)
C
	REAL PZ1(NP1),PZ2(NP2),PZ3(NP3),PZ4(NP4)
	REAL PM1(NP1),PM2(NP2),PM3(NP3),PM4(NP4)
	REAL PN1(NP1),PN2(NP2),PN3(NP3),PN4(NP4)
C
      REAL DIVZ(IF1,JF1,NF)
C
      REAL R1(IF1,JF1),R2(IF1,JF1),R3(IF1,JF1)
      REAL R4(IF1,JF1),R5(IF1,JF1),R6(JF1)
      REAL C1(JF1),C2(JF1)
	REAL CF1(IF1),CF2(JF1),CF3(IF1),CF4(JF1)
	REAL TM,RX2,RX3,RX4
C
	INTEGER  KK, K1, L12(4), L23(4), L34(4),NC2, NC3, NC4, K2
	INTEGER IS, JS, IE, JE, TEMP1, TEMP2,TFMAX
	INTEGER IP1(NP1), JP1(NP1),CHAF(ROWF,COLF), IP2(NP2), JP2(NP2)
	INTEGER IP3(NP3), JP3(NP3), IP4(NP4), JP4(NP4)
C	
	CHARACTER *20 REG1NAME, REG2NAME, REG3NAME, REG4NAME 
        CHARACTER *20 DEF1_1NAME, DEF1_2NAME
        CHARACTER *20 DEF2NAME, DEF3NAME, DEF4NAME
	CHARACTER *20 ZM1NAME, ZM2NAME, ZM3NAME, ZM4NAME
	CHARACTER *20 PZ1NAME, PZ2NAME, PZ3NAME, PZ4NAME
	CHARACTER *20 PM1NAME, PM2NAME, PM3NAME, PM4NAME
	CHARACTER *20 PN1NAME, PN2NAME, PN3NAME, PN4NAME
	CHARACTER *20 MM1NAME, MM2NAME, MM3NAME, MM4NAME
	CHARACTER *20 NM1NAME, NM2NAME, NM3NAME, NM4NAME
	CHARACTER *20 ZMN1NAME, ZMN2NAME, ZMN3NAME, ZMN4NAME
	CHARACTER *20 TIMEFAULT
C	END_TAG_PARAM_DECLARE
C	Parameter settings
C	{START_STATIC}
	REG1NAME = '__REG1NAME__'
	REG2NAME = '__REG2NAME__'
	REG3NAME = '__REG3NAME__'
	REG4NAME = '__REG4NAME__'
	TIMEFAULT = '__TIMEFAULTNAME__'
	DEF1_1NAME = '__DEF1_1NAME__'
	DEF1_2NAME = '__DEF1_2NAME__'
	DEF2NAME = '__DEF2NAME__'
	DEF3NAME = '__DEF3NAME__'
	DEF4NAME = '__DEF4NAME__'
	ZM1NAME  = '__ZM1__'
	ZM2NAME  = '__ZM2__'
	ZM3NAME  = '__ZM3__'
	ZM4NAME  = '__ZM4__'
	MM1NAME  = '__MM1NAME__'
	MM2NAME  = '__MM2NAME__'
	MM3NAME  = '__MM3NAME__'
	MM4NAME  = '__MM4NAME__'
	NM1NAME  = '__NM1NAME__'
	NM2NAME  = '__NM2NAME__'
	NM3NAME  = '__NM3NAME__'
	NM4NAME  = '__NM4NAME__'
	ZMN1NAME  = '__ZMN1NAME__'
	ZMN2NAME  = '__ZMN2NAME__'
	ZMN3NAME  = '__ZMN3NAME__'
	ZMN4NAME  = '__ZMN4NAME__'
	PZ1NAME  = '__PZ1NAME__'
	PZ2NAME  = '__PZ2NAME__'
	PZ3NAME  = '__PZ3NAME__'
	PZ4NAME  = '__PZ4NAME__'
	PM1NAME = '__PM1NAME__'
	PM2NAME = '__PN2NAME__'
	PM3NAME = '__PM3NAME__'
	PM4NAME = '__PM4NAME__'
	PN1NAME = '__PM1NAME__'
	PN2NAME = '__PM2NAME__'
	PN3NAME = '__PM3NAME__'
	PN4NAME = '__PM4NAME__'
	L12(1)=__L12_1__
	L12(2)=__L12_2__
	L12(3)=__L12_3__
	L12(4)=__L12_4__
	L23(1)=__L23_5__
	L23(2)=__L23_2__
	L23(3)=__L23_3__
	L23(4)=__L23_4__
	L34(1)=__L34_1__
	L34(2)=__L34_2__
	L34(3)=__L34_3__
	L34(4)=__L34_4__
C	{END_STATIC}
c
C	{START_DYNAMIC}
C	{END_DYNAMIC}
c	IP1(1)=__IP1_1__
c	JP1(1)=__JP1_1__
c	IP1(2)=__IP1_2__
c	JP1(2)=__JP1_2__
c	IP2(1)=__IP2_1__
c	JP2(1)=__JP2_1__
c	IP2(2)=__IP2_2__
c	JP2(2)=__JP2_2__
C	END_TAG_OBSERVE_POINT_R2
C 	START_TAG_OBSERVE_POINT_R3
c	IP3(1)=__IP3_1__
c	JP3(1)=__JP3_1__
c	IP3(2)=__IP3_2__
c	JP3(2)=__JP3_2__
C	END_TAG_OBSERVE_POINT_R3
C	START_TAG_OBSERVE_POINT_R4
c	IP4(1)=__IP4_1__
c	JP4(1)=__JP4_1__
c	IP4(2)=__IP4_2__
c	JP4(2)=__JP4_2__
C	END_TAG_OBSERVE_POINT_R4
c
C	START_INITIAL_CONDITION
C
C	START_TAG_OPEN_TIME_HISTORY
C
	OPEN(51,FILE=PZ1NAME)
      OPEN(52,FILE=PZ2NAME)
	OPEN(53,FILE=PZ3NAME)
	OPEN(54,FILE=PZ4NAME)
C
	OPEN(71,FILE=PM1NAME)
	OPEN(72,FILE=PM2NAME)
	OPEN(73,FILE=PM3NAME)
	OPEN(74,FILE=PM4NAME)
C
	OPEN(75,FILE=PN1NAME)
	OPEN(76,FILE=PN2NAME)
	OPEN(77,FILE=PN3NAME)
	OPEN(78,FILE=PN4NAME)
C	END_TAG_OPEN_TIME_HISTORY
C	START_TAG_OPEN_TIME_FAULT
        OPEN(83,FILE=TIMEFAULT)
C	END_TAG_OPEN_TIME_FAULT
C	START_TAG_OPEN_BATHYMETRY
	OPEN(1,FILE=REG1NAME)
	OPEN(2,FILE=REG2NAME)
	OPEN(3,FILE=REG3NAME)
	OPEN(4,FILE=REG4NAME)
C	END_TAG_OPEN_BATHYMETRY
C	START_TAG_READ_BATHYMETRY
	CALL DEPTH (IF1,JF1,HZ1,1)
	CALL DEPTH (IF2,JF2,HZ2,2)
	CALL DEPTH (IF3,JF3,HZ3,3)
	CALL DEPTH (IF4,JF4,HZ4,4)
	CLOSE(1)
	CLOSE(2)
	CLOSE(3)
	CLOSE(4)
C	END_TAG_READ_BATHYMETRY
C	START_TAG_OPEN_DEFORM
	OPEN(62,FILE=DEF1_1NAME)
	OPEN(63,FILE=DEF1_2NAME)	
	OPEN(12,FILE=DEF2NAME)
	OPEN(13,FILE=DEF3NAME)
	OPEN(14,FILE=DEF4NAME)
C	END_TAG_OPEN_DEFORM
C	INITIAL DEFORMATION DATA
C
      CALL INTIALDEFORM (IF1,JF1,Z1,CHAF,ROWF,COLF,TFMAX,83)
      CALL DIVDEFORM (IF1,JF1,DIVZ,1,62,NR,NF)
C	CALL DIVDEFORM (IF1,JF1,DIVZ,2,63,NR,NF)
C
C	Read deformation files
C						
      CALL DEFORM (IF2,JF2,Z2,12)
      CALL DEFORM (IF3,JF3,Z3,13)
      CALL DEFORM (IF4,JF4,Z4,14)
C
C	Close deformation files
C
	CLOSE(62)
	CLOSE(63)
	CLOSE(12)
	CLOSE(13)
	CLOSE(14)
C
      CALL INITIAL (IF1,JF1,Z1,M1,N1,HZ1,DZ1,ZM1,TIDE)
      CALL INITIAL (IF2,JF2,Z2,M2,N2,HZ2,DZ2,ZM2,TIDE)
      CALL INITIAL (IF3,JF3,Z3,M3,N3,HZ3,DZ3,ZM3,TIDE)
      CALL INITIAL (IF4,JF4,Z4,M4,N4,HZ4,DZ4,ZM4,TIDE)
C
C  ******** DETERMINE WATER DEPTH AT POINT OF DISCHARGE ********
C
      CALL HMN(IF2,JF2,HZ2,HM2,HN2)
      CALL HMN(IF3,JF3,HZ3,HM3,HN3)
      CALL HMN(IF4,JF4,HZ4,HM4,HN4)
C
C  ********* MAIN CALCULATION *************
C
	RX2=DT/DX2
	RX3=DT/DX3
	RX4=DT/DX4
C
C ---------- ADJUST DEPTH  ----------
C
      CALL GIORS  (IF1,JF1,GX,HZ1)
C
      DO I=1,IF1
		DO J=1,JF1  
			IF (HZ1(I,J) < GX) THEN 
				GOTO 15
			ELSEIF (HZ1(I,J) < GX1) THEN
				HZ1(I,J) = GX1
			ENDIF
   15		ENDDO
      ENDDO
C
      CALL DPCHANGE (IF1,JF1,HZ1,Z1,GX)
      CALL DPCHANGE (IF2,JF2,HZ2,Z2,TH2)
      CALL DPCHANGE (IF3,JF3,HZ3,Z3,TH3)

      CALL PARAME (R1,R2,R3,R4,R5,R6,C1,C2,HZ1,IF1,JF1,DS1,DT1,YG,GX)
      CALL CF(IF1,JF1,CF1,CF2,CF3,CF4,HZ1,GG,GX)
C
      CALL ALIMIT (IF1,JF1,IS,JS,IE,JE)
C
      DO 10 K1=1,NT1
C	
		KK=K1*DT1
C
		CALL MASS (IF1,JF1,IS,JS,IE,JE,Z1,M1,N1,R1,R6,GX,HZ1)
C
		CALL OPENBOUNDARY (IF1,JF1,IS,JS,IE,JE,Z1,M1,N1,CF1,CF2,CF3,CF
     &4,HZ1,GX)
C    
     	    IF ((KK-DT1).LE.TFMAX) THEN
C
			DO T1=1,ROWF
				TEMP1=CHAF(T1,1)
				TEMP2=CHAF(T1,2)
C
				IF ((KK-DT1).EQ.TEMP2) THEN
	     			CALL AFDEFORM (IF1,JF1,Z1,DIVZ,NF,TEMP1,TEMP2)
				END IF
C
			END DO
C
		END IF
C
		CALL MOMENT(IF1,JF1,IS,JS,IE,JE,Z1,M1,N1,R2,R3,R4,R5,HZ1,GX)
C	
		DO 20 K2=1,NT2
C
			KK=(K1-1)*DT1+K2
C				
			CALL INTERQT (IF1,JF1,K2,NT2,M1,N1,M1T,N1T)
C
			CALL JNQ_S2C (IF1,JF1,IF2,JF2,M1T,N1T,M2,N2,HZ2,L12,1111)
C		
			CALL NLMASS (IF2,JF2,M2,N2,Z2,HZ2,DZ2,TH2,RX2,KK,NC2,2)
			CALL NLMASS (IF3,JF3,M3,N3,Z3,HZ3,DZ3,TH3,RX3,KK,NC3,3)
			CALL NLMASS (IF4,JF4,M4,N4,Z4,HZ4,DZ4,TH4,RX4,KK,NC4,4)
C
			CALL JNZ(IF2,JF2,IF3,JF3,Z2,Z3,DZ2,DZ3,HZ3,L23,1111)
			CALL JNZ(IF3,JF3,IF4,JF4,Z3,Z4,DZ3,DZ4,HZ4,L34,1111)
C
			CALL NLMMT (TH2,IF2,JF2,Z2,M2,N2,DZ2,DM2,DN2,
     &					HZ2,HM2,HN2,RX2,DT,FM)
			CALL NLMMT (TH3,IF3,JF3,Z3,M3,N3,DZ3,DM3,DN3,
     &					HZ3,HM3,HN3,RX3,DT,FM)
			CALL NLMMT (TH4,IF4,JF4,Z4,M4,N4,DZ4,DM4,DN4,
     &					HZ4,HM4,HN4,RX4,DT,FM)
C
			CALL JNQ (IF2,JF2,IF3,JF3,M2,N2,M3,N3,HZ3,L23,1111)
			CALL JNQ (IF3,JF3,IF4,JF4,M3,N3,M4,N4,HZ4,L34,1111)
C
			CALL CHANGE (IF2,JF2,Z2,M2,N2,DZ2)
			CALL CHANGE (IF3,JF3,Z3,M3,N3,DZ3)
			CALL CHANGE (IF4,JF4,Z4,M4,N4,DZ4)
C
			CALL ZMAX (IF1,JF1,Z1,ZM1)
			CALL ZMAX (IF2,JF2,Z2,ZM2)
			CALL ZMAX (IF3,JF3,Z3,ZM3)
			CALL ZMAX (IF4,JF4,Z4,ZM4)
C
c			CALL MNMAX (IF1,JF1,M1,N1,Z1,MM1,NM1,ZMN1)
c			CALL MNMAX (IF2,JF2,M2,N2,Z2,MM2,NM2,ZMN2)
c			CALL MNMAX (IF3,JF3,M3,N3,Z3,MM3,NM3,ZMN3)
c			CALL MNMAX (IF4,JF4,M4,N4,Z4,MM4,NM4,ZMN4)

			IF (MOD(KK,NTP).EQ.0) THEN
				CALL OUTZ1 (IF1,JF1,Z1,KK)
				CALL OUTZ2 (IF2,JF2,Z2,KK)
				CALL OUTZ3 (IF3,JF3,Z3,KK)
				CALL OUTZ4 (IF4,JF4,Z4,KK)
C
C				CALL OUTM1 (IF1,JF1,M1,KK)
C				CALL OUTM2 (IF2,JF2,M2,KK)
C				CALL OUTM3 (IF3,JF3,M3,KK)
C				CALL OUTM4 (IF4,JF4,M4,KK)
CC
C				CALL OUTN1 (IF1,JF1,N1,KK)
C				CALL OUTN2 (IF2,JF2,N2,KK)
C				CALL OUTN3 (IF3,JF3,N3,KK)
C				CALL OUTN4 (IF4,JF4,N4,KK)
			END IF
C
C			IF (MOD(KK,KP) .EQ. 0) THEN
C				TM = KK*DT/60.0
C				CALL POINT(IF1,JF1,Z1,M1,N1,NP1,IP1,JP1,PZ1,PM1,PN1,
C     &TM,51,71,75)
C				CALL POINT(IF2,JF2,Z2,M2,N2,NP2,IP2,JP2,PZ2,PM2,PN2,
C     &TM,52,72,76)
C				CALL POINT(IF3,JF3,Z3,M3,N3,NP3,IP3,JP3,PZ3,PM3,PN3,
C     &TM,53,73,77)
C				CALL POINT(IF4,JF4,Z4,M4,N4,NP4,IP4,JP4,PZ4,PM4,PN4,
C     &TM,54,74,78)
C			END IF
C
			IF (MOD(KK,1).EQ.0) THEN
				WRITE(6,'(A15,I6)')'TIME STEP No.', KK
			END IF

C
   20		CONTINUE
C
		CALL CHANGE (IF1,JF1,Z1,M1,N1,DZ1)

   10 CONTINUE
C
C	Output ZM
C
	OPEN(41,FILE=ZM1NAME)
	OPEN(42,FILE=ZM2NAME)
	OPEN(43,FILE=ZM3NAME)
	OPEN(44,FILE=ZM4NAME)
C
c	OPEN(91,FILE=MM1NAME)
c	OPEN(92,FILE=MM2NAME)
c	OPEN(93,FILE=MM3NAME)
	OPEN(94,FILE=MM4NAME)

c	OPEN(95,FILE=NM1NAME)
c	OPEN(96,FILE=NM2NAME)
c	OPEN(97,FILE=NM3NAME)
	OPEN(98,FILE=NM4NAME)

c	OPEN(99,FILE=ZMN1NAME)
c	OPEN(100,FILE=ZMN2NAME)
c	OPEN(101,FILE=ZMN3NAME)
	OPEN(102,FILE=ZMN4NAME) 

	CALL OUTZMAX (IF1,JF1,NDP1,ZM1,41)
	CALL OUTZMAX (IF2,JF2,NDP2,ZM2,42)
	CALL OUTZMAX (IF3,JF3,NDP3,ZM3,43)
	CALL OUTZMAX (IF4,JF4,NDP4,ZM4,44)

c	CALL OUTMMAX (IF1,JF1,NDP1,MM1,91)
c	CALL OUTMMAX (IF2,JF2,NDP2,MM2,92)
c	CALL OUTMMAX (IF3,JF3,NDP3,MM3,93)
	CALL OUTMMAX (IF4,JF4,NDP4,MM4,94)

c	CALL OUTNMAX (IF1,JF1,NDP1,NM1,95)
c	CALL OUTNMAX (IF2,JF2,NDP2,NM2,96)
c	CALL OUTNMAX (IF3,JF3,NDP3,NM3,97)
	CALL OUTNMAX (IF4,JF4,NDP4,NM4,98)

c	CALL OUTZMNMAX (IF1,JF1,NDP1,ZMN1,99)
c	CALL OUTZMNMAX (IF2,JF2,NDP2,ZMN2,100)
c	CALL OUTZMNMAX (IF3,JF3,NDP3,ZMN3,101)
	CALL OUTZMNMAX (IF4,JF4,NDP4,ZMN4,102) 

C
C	Close output files
C
	CLOSE(41)
	CLOSE(42)
	CLOSE(43)
	CLOSE(44)
C
c	CLOSE(51)
c	CLOSE(52)
c	CLOSE(53)
	CLOSE(54)
C		
c      CLOSE(91)
c	CLOSE(92)
c	CLOSE(93)
	CLOSE(94)

c	CLOSE(95)
c	CLOSE(96)
c	CLOSE(97)
	CLOSE(98)

c	CLOSE(99)
c	CLOSE(100)
c	CLOSE(101)
	CLOSE(102)
	STOP
      END
C
C
C
C  ******** READ DEPTH DATA *************
C
      SUBROUTINE DEPTH(IFN,JFN,HZ,NDEPTH)
C
   	REAL HZ(IFN,JFN)    
	DO 10 J=JFN,1,-1
	  READ(NDEPTH,'(F8.2)')(HZ(I,J),I=1,IFN)
   10 CONTINUE
      WRITE(6,*)'READ DEPTH OK'
	WRITE(6,'(2F8.2)') HZ(1,1),HZ(IFN,JFN)
	RETURN
	END
C
C  ******** INITIAL DEFORMATION DATA *************
C
      SUBROUTINE INTIALDEFORM (IFN,JFN,Z,CHAF,ROWF,COLF,TFMAX,NCHARF)
C
      INTEGER IFN, JFN, ROWF, COLF, TFMAX
	INTEGER CHAF(ROWF,COLF)
      REAL Z(IFN,JFN,2)
	TFMAX=0
      DO 10 I=1,ROWF
         DO 10 J=1,COLF
	   READ(NCHARF,'(I6)') CHAF(I,J)
	   IF (CHAF(I,J)>TFMAX) TFMAX=CHAF(I,2)  
   10 CONTINUE
      
	DO 70 K=1,2
		DO 70 J=1,JFN
            DO 70 I=1,IFN
               Z(I,J,K)=0.0	   	
   70 CONTINUE
      RETURN
	END


C  ******** READ DEFORMATION DATA *************
C
      SUBROUTINE DEFORM(IFN,JFN,Z,NDEFORM)
C
   	REAL Z(IFN,JFN,2)    
	DO 10 J=JFN,1,-1
	  READ(NDEFORM,'(F8.2)')(Z(I,J,1),I=1,IFN)
   10 CONTINUE
C
      DO 20 J=1,JFN
        DO 20 I=1,IFN
	    Z(I,J,2)=Z(I,J,1)
   20 CONTINUE
C
      WRITE(6,*)'READ DEFORMATION OK'
	WRITE(6,'(2F8.2)') Z(1,1,1),Z(IFN,JFN,1)
	RETURN
	END
C
C  ******** DIVIDE DEFORMATION DATA ************* 
C
      SUBROUTINE DIVDEFORM (IFN,JFN,DIVZ,N,NDEFORM,NR,NF)
C
	INTEGER IFN, JFN, N, NR, NF
	REAL DIVZ(IFN,JFN,NF),TEMP(IFN,JFN)
      DO 10 J=JFN,1,-1
		READ (NDEFORM,'(F8.2)')(TEMP(I,J),I=1,IFN)
   10	CONTINUE
C
	DO 20 J=1,JFN
		  DO 20 I=1,IFN
		  	    DIVZ(I,J,N)=TEMP(I,J)/(NR)
   20	CONTINUE 
      RETURN
	END
C
C  ******** READ AFTER DEFORMATION DATA *************
C
	SUBROUTINE AFDEFORM (IFN,JFN,Z,DIVZ,NF,NOF,TOF)
C
	INTEGER IFN, JFN, NF, NOF, TOF 
      REAL DIVZ(IFN,JFN,NF),Z(IFN,JFN,2)	
    	DO 20 J=1,JFN
	  DO 20 I=1,IFN
	    Z(I,J,2)=Z(I,J,2)+DIVZ(I,J,NOF)
   20	CONTINUE	
      WRITE(6,'(A25,I6,I6)')'AFTER DEFORMATION OK', NOF,TOF
	RETURN
	END
C
C ******** INITIAL CONDITION ***********
C
      SUBROUTINE INITIAL (IFN,JFN,Z,M,N,HZ,DZ,ZM,TIDE)
C
      INTEGER IFN, JFN
	REAL TIDE
	REAL Z(IFN,JFN,2),M(IFN,JFN,2),N(IFN,JFN,2), 
     &	      HZ(IFN,JFN), DZ(IFN,JFN,2), ZM(IFN,JFN)
C
      DO 10 K=1,2
        DO 10 J=1,JFN
          DO 10 I=1,IFN
            M(I,J,K)=0.0
            N(I,J,K)=0.0
		  DZ(I,J,K)=0.0
		  ZM(I,J)=0.0
   10 CONTINUE
C
      DO J=1, JFN
         DO I=1, IFN
            HZ(I,J) = HZ(I,J) + TIDE - Z(I,J,1) 
            IF (HZ(I,J) .LE. 0.0) THEN
               Z(I,J,1) = 0.0
               Z(I,J,2) = Z(I,J,1)
            ELSE
               DZ(I,J,1) = HZ(I,J) + Z(I,J,1)
               DZ(I,J,2) = HZ(I,J) + Z(I,J,2)
            END IF
         END DO
      END DO
C
      WRITE(6,*)'INITIAL CONDITION OK'

	RETURN
      END
C
C *** CALCULATION OF WATER DEPTH AT THE POINT OF DISCHARGE
C
      SUBROUTINE HMN(IFN,JFN,HZ,HM,HN)
C
      INTEGER   IFN, JFN
      REAL      HZ(IFN,JFN), HM(IFN,JFN), HN(IFN,JFN)

      DO J=1, JFN
         DO I=1, IFN
            IF (I .LT. IFN) THEN
               HM(I,J) = 0.5*(HZ(I,J)+HZ(I+1,J))
            ELSE
               HM(I,J) = HZ(I,J)
            END IF
            IF (J .LT. JFN) THEN
               HN(I,J) = 0.5*(HZ(I,J)+HZ(I,J+1))
            ELSE
               HN(I,J) = HZ(I,J)
            END IF
         END DO
      END DO

      RETURN
      END
C
C *********** MASS CONSERVATION ***********
C
      SUBROUTINE NLMASS(IFN,JFN,M,N,Z,HZ,DZ,TH,RX,KK,NC,NREG)
C
C
C	Definition of Parameters in Main Program
C	------------------------------------------------------------------------------
C		Name	Dimension		I/O		Description						
C	------------------------------------------------------------------------------
C		IFN		1				I		The dimension of data in the X direction
C		JFN		1				I		The dimension of data in the Y direction
C		M		IFN x JFN x 2	I		Water discharge in the X direction
C		N		IFN x JFN x 2	I		Water discharge in the Y direction
C		Z		IFN x JFN x 2	I/O		The vertical displacement of water surface above the still water lavel
C		HZ		IFN x JFN x 1	I		Still water depth
C		DZ		IFN x JFN x 2	O		Total water depth
C		TH		1				I		The threshold for computing the land. 
C										If TH=0.0, computation is not done on the land.
C										If TH=-A, computation will be done up to the land elevation of A.
C		R		1				I		DT/DX
C		K		1				I		Time step No.
C		NREG	1				I		Region No.
C		NC		1				O		Error control number (if NC=1, an error occurs.)
C


      PARAMETER   (GX=1.0E-5)
C
      INTEGER   IFN, JFN, KK, NC, NREG
      REAL      Z(IFN,JFN,2), HZ(IFN,JFN), DZ(IFN,JFN,2)
      REAL      M(IFN,JFN,2), N(IFN,JFN,2), RX, TH, ZZ, DD

      DO J=2, JFN
		DO I=2, IFN
			IF (HZ(I,J) .GE. TH) THEN
				ZZ = Z(I,J,1) - RX*(M(I,J,1)-M(I-1,J,1))
     &				          - RX*(N(I,J,1)-N(I,J-1,1))
				IF (ABS(ZZ) .LT. GX) ZZ = 0.0
				DD = ZZ + HZ(I,J)
				IF (DD .LT. GX) DD = 0.0
				DZ(I,J,2) = DD
				Z(I,J,2)  = DD - HZ(I,J)
C
C				*** Checking the Stability ***
C
				IF(ABS(Z(I,J,2)).GT.100.0) THEN
					NC=1
					WRITE(6,'(A24,3I6)')'Over flow Z at (KK,I,J) :', KK,I,J
					IF(NREG.EQ.1)WRITE(6,*)'Within Region 1'
					IF(NREG.EQ.2)WRITE(6,*)'Within Region 2'
					IF(NREG.EQ.3)WRITE(6,*)'Within Region 3'
					IF(NREG.EQ.4)WRITE(6,*)'Within Region 4'
					WRITE(*,*)'Computation is unstable.'
					RETURN
				END IF
			END IF
         END DO
      END DO
      RETURN
      END


C
C ********** CONNECTION OF WATER LEVEL **********
C
      SUBROUTINE JNZ(IX,JX,IY,JY,ZX,ZY,DZX,DZY,HY,L0,BCHK)
C
      INTEGER   IX, JX, IY, JY, L0(4), BCHK, CHK
      INTEGER   ISS, JSS, IES, JES, ISL, JSL, IEL, JEL
	INTEGER   II, JJ, I1, J1, L, KB
      REAL      ZX(IX,JX,2), ZY(IY,JY,2), DZX(IX,JX,2), DZY(IY,JY,2)
      REAL      HY(IY,JY)
	REAL      S, SD
C
      ISS=2
      JSS=2
      IES=IY
      JES=JY
      ISL=L0(1)
      JSL=L0(2)
      IEL=L0(3)
      JEL=L0(4)
      CHK=BCHK
      KB=CHK/1000
C
      IF (KB .EQ. 1) THEN
         CHK = CHK - 1000
         II = ISL
         JJ = JSL
         I1 = ISS
         J1 = JSS
         DO WHILE(I1+2.LE.IES)
            S=0.0
            L=0
            SD=0.0
            DO J=J1, J1+2
              DO I=I1, I1+2
                 IF(HY(I,J).GT.0.0)THEN
                    S=S+ZY(I,J,2)
                    SD=SD+DZY(I,J,2)
                    L=L+1
                 END IF
              END DO
            END DO
            IF(L.GE.5)THEN
               ZX(II,JJ,2)=S/L
               DZX(II,JJ,2)=SD/L
            ELSE
               ZX(II,JJ,2)=0.0
            END IF
            II=II+1
            I1=I1+3
         END DO
      END IF
C
      KB=CHK/100
      IF(KB.EQ.1)THEN
         CHK=CHK-100
         II=IEL
         JJ=JSL
         I1=IES-2
         J1=JSS
            DO WHILE(J1+2.LE.JES)
               S=0.0
               L=0
               SD=0.0
               DO J=J1, J1+2
                  DO I=I1, I1+2
                     IF(HY(I,J).GT.0.0)THEN
                        S=S+ZY(I,J,2)
                        SD=SD+DZY(I,J,2)
                        L=L+1
                     END IF
                  END DO
               END DO
              IF(L.GE.5)THEN
                 ZX(II,JJ,2)=S/L
                 DZX(II,JJ,2)=SD/L
              ELSE
                 ZX(II,JJ,2)=0.0
              END IF
              JJ=JJ+1
              J1=J1+3
         END DO
      END IF
C
      KB=CHK/10
      IF(KB.EQ.1)THEN
        CHK=CHK-10
        II=ISL
        JJ=JEL
        I1=ISS
        J1=JES-2
        DO WHILE(I1+2.LE.IES)
          S=0.0
          L=0
          SD=0.0
          DO J=J1, J1+2
            DO I=I1, I1+2
              IF(HY(I,J).GT.0.0)THEN
                S=S+ZY(I,J,2)
                SD=SD+DZY(I,J,2)
                L=L+1
              END IF
            END DO
          END DO
          IF(L.GE.5)THEN
            ZX(II,JJ,2)=S/L
            DZX(II,JJ,2)=SD/L
          ELSE
            ZX(II,JJ,2)=0.0
          END IF
          II=II+1
          I1=I1+3
        END DO
      END IF
C
      IF(CHK.EQ.1)THEN
        II=ISL
        JJ=JSL
        I1=ISS
        J1=JSS
        DO WHILE(J1+2.LE.JES)
          S=0.0
          L=0
          SD=0.0
          DO I=I1, I1+2
            DO J=J1, J1+2
              IF(HY(I,J).GT.0.0)THEN
                S=S+ZY(I,J,2)
                SD=SD+DZY(I,J,2)
                L=L+1
              END IF
            END DO
          END DO
          IF(L.GE.5)THEN
            ZX(II,JJ,2)=S/L
            DZX(II,JJ,2)=SD/L
          ELSE
            ZX(II,JJ,2)=0.0
          END IF
          JJ=JJ+1
          J1=J1+3
        END DO
      END IF
      RETURN
      END
C
C
C *********** MOMENTUM CONSERVATION *************
C
      SUBROUTINE NLMMT(TH,IFN,JFN,Z,M,N,DZ,DM,DN,HZ,HM,HN,RX,DT,FM)
C
      PARAMETER   (GX=1.0E-5, GG=9.81)
C
      INTEGER   IFN, JFN
      REAL      TH, Z(IFN,JFN,2), M(IFN,JFN,2), N(IFN,JFN,2)
      REAL      DZ(IFN,JFN,2), DM(IFN,JFN,2), DN(IFN,JFN,2)
      REAL      HZ(IFN,JFN), HM(IFN,JFN), HN(IFN,JFN), RX, DT, FM
	REAL      DM1, DM2, DN1, DN2, FN
C
      DO 10 K=1,2
        DO 10 J=1,JFN
          DO 10 I=1,IFN
            DM(I,J,K)=0.0
            DN(I,J,K)=0.0
   10 CONTINUE   
C
      DO J=1, JFN
         DO I=1, IFN	 
	      IF (I .LT. IFN) THEN
               DM1 = 0.25*(Z(I,J,1)+Z(I,J,2)+Z(I+1,J,1)+Z(I+1,J,2))
     &             + 0.5*(HZ(I,J)+HZ(I+1,J))
               DM2 = 0.5*(Z(I,J,2)+Z(I+1,J,2)+HZ(I,J)+HZ(I+1,J))
            ELSE
               DM1 = Z(I,J,2) + HZ(I,J)
               DM2 = Z(I,J,2) + HZ(I,J)
            END IF
            IF (DM1 .GE. GX) DM(I,J,1) = DM1
            IF (DM2 .GE. GX) DM(I,J,2) = DM2
C
            IF (J .LT. JFN) THEN
               DN1 = 0.25*(Z(I,J,1)+Z(I,J,2)+Z(I,J+1,1)+Z(I,J+1,2))
     &             + 0.5*(HZ(I,J)+HZ(I,J+1))
               DN2 = 0.5*(Z(I,J,2)+Z(I,J+1,2)+HZ(I,J)+HZ(I,J+1))
            ELSE
               DN1 = Z(I,J,2)+HZ(I,J)
               DN2 = Z(I,J,2)+HZ(I,J)
            END IF
            IF (DN1 .GE. GX) DN(I,J,1) = DN1
            IF (DN2 .GE. GX) DN(I,J,2) = DN2
         END DO
      END DO  
C
      FN=0.5*DT*GG*FM**2
C
C   ------- X-DIRECTION -------
C
      DO J=1, JFN
         DO I=1, IFN
            IF (HZ(I,J).GT.TH .AND. HM(I,J).GT.TH) THEN
               CALL XMMT(GG, I, J, IFN, JFN, HZ, Z, DZ, DM,
     &                                      M, N, RX, FN)
            END IF
C
C   ------- Y-DIRECTION -------
C
            IF (HZ(I,J).GT.TH .AND. HN(I,J).GT.TH) THEN
               CALL YMMT(GG, I, J, IFN, JFN, HZ, Z, DZ, DN,
     &                                      M, N, RX, FN)
            END IF
         END DO
      END DO

      RETURN
      END
C
C ---------------------------------------------------------- 
C
      SUBROUTINE XMMT(GG,I,J,IFN,JFN,HZ,Z,DZ,DM,M,N,RX,FN)
C
      INTEGER I,J,IFN,JFN
      REAL    GG, RX, FN
      REAL    Z(IFN,JFN,2),M(IFN,JFN,2),N(IFN,JFN,2)
      REAL    DZ(IFN,JFN,2),HZ(IFN,JFN),DM(IFN,JFN,2)
	REAL    DD, XNN, FF, XM, XDM, XNE, XMM0
C
      PARAMETER (GX=1.0E-5,GX2=1.0E-5)
C
      IF(I.EQ.IFN)THEN
         M(I,J,2)=0.0
         RETURN
      END IF
C
      IF(DZ(I,J,2).GT.GX)THEN
          IF(DZ(I+1,J,2).GT.GX)THEN
             DD=DM(I,J,2)
          ELSE
             IF(Z(I,J,2)+HZ(I+1,J).GT.GX)THEN
                DD=Z(I,J,2)+HZ(I+1,J)
             ELSE
                M(I,J,2)=0.0
                RETURN
             END IF
          END IF
      ELSE
          IF(DZ(I+1,J,2).GT.GX)THEN
             IF(Z(I+1,J,2)+HZ(I,J).GT.GX)THEN
                DD=Z(I+1,J,2)+HZ(I,J)
             ELSE
                M(I,J,2)=0.0
                RETURN
             END IF
          ELSE
             M(I,J,2)=0.0
             RETURN
          END IF
      END IF
C
C   ------  LINEAR TERM  ------
C
      IF(J.NE.1)THEN
         IF(DD.GE.GX)THEN
            XNN=0.25*(N(I,J,1)+N(I+1,J,1)+N(I,J-1,1)+N(I+1,J-1,1))
            FF=FN*SQRT(M(I,J,1)**2+XNN**2)/DD**(7.0/3.0)
            XM=(1.0-FF)*M(I,J,1)-GG*RX*DD*(Z(I+1,J,2)-Z(I,J,2))
         ELSE
            M(I,J,2)=0.0
            RETURN
         END IF
      ELSE
         M(I,J,2)=0.0
         RETURN
      END IF
C
C     ------  NON-LINEAR TERM  ------
C
C     ++++++++++++
      IF(I.GT.3.AND.I.LT.IFN-3.AND.J.GT.3.AND.J.LT.JFN-3)THEN
C     ++++++++++++
C
C     ************
      IF(DM(I,J,1).GE.GX)THEN
C     ************
C
      IF(M(I,J,1).GT.0.0)THEN
         IF(I.NE.1)THEN
            IF(DM(I-1,J,1).GE.GX)THEN
               XDM=M(I-1,J,1)**2/DM(I-1,J,1)
               IF(DZ(I-1,J,2).LT.GX)XDM=0.0
               IF(DZ(I,J,2).LT.GX)XDM=0.0
            ELSE
               XDM=0.0
            END IF
            XM=XM-RX*(M(I,J,1)**2/DM(I,J,1)-XDM) 
         END IF
      ELSE
         IF(DM(I+1,J,1).GE.GX)THEN
            XDM=M(I+1,J,1)**2/DM(I+1,J,1)
            IF(DZ(I+2,J,2).LT.GX)XDM=0.0
            IF(DZ(I+1,J,2).LT.GX)XDM=0.0
         ELSE
            XDM=0.0
         END IF
         XM=XM-RX*(XDM-M(I,J,1)**2/DM(I,J,1))
      END IF
C
      IF(XNN.GT.0.0)THEN
         IF(J.NE.2)THEN
            XNE=0.25*(N(I,J-1,1)+N(I+1,J-1,1)+N(I,J-2,1)+N(I+1,J-2,1))
            IF(DM(I,J-1,1).GE.GX)THEN
               XDM=M(I,J-1,1)*XNE/DM(I,J-1,1)
               IF(DZ(I,J-2,2).LT.GX)THEN
                XDM=0.0
                  XMM0=XM-RX*(M(I,J,1)*XNN/DM(I,J,1)-XDM)
               ELSE
                  XMM0=XM-RX*(M(I,J,1)*XNN/DM(I,J,1)-XDM)
                  IF(DZ(I,J-1,2).LT.GX)XMM0=XM
                  IF(DZ(I+1,J-1,2).LT.GX)XMM0=XM
                  IF(DZ(I+1,J-2,2).LT.GX)XMM0=XM
               END IF
               XM=XMM0/(1.0+FF) 
            ELSE
               XDM=0.0
               XM=XM-RX*(M(I,J,1)*XNN/DM(I,J,1)-XDM)
               XM=XM/(1.0+FF)
            END IF
         END IF
      ELSE
         XNE=0.25*(N(I,J+1,1)+N(I+1,J+1,1)+N(I,J,1)+N(I+1,J,1))
         IF(DM(I,J+1,1).GE.GX)THEN
            XDM=M(I,J+1,1)*XNE/DM(I,J+1,1)
            IF(DZ(I,J+1,2).LT.GX)THEN
               XDM=0.0
               XMM0=XM-RX*(XDM-M(I,J,1)*XNN/DM(I,J,1))
            ELSE
               XMM0=XM-RX*(XDM-M(I,J,1)*XNN/DM(I,J,1))
               IF(DZ(I,J+2,2).LT.GX)XMM0=XM
               IF(DZ(I+1,J+1,2).LT.GX)XMM0=XM
               IF(DZ(I+1,J+2,2).LT.GX)XMM0=XM
            END IF
            XM=XMM0/(1.0+FF) 
         ELSE
            XDM=0.0
            XM=XM-RX*(XDM-M(I,J,1)*XNN/DM(I,J,1))
            XM=XM/(1.0+FF)
         END IF
      END IF
C
C     ************
      ELSE
         XM=XM/(1.0+FF)
      END IF
C     ************
C
C     ++++++++++++
      ELSE
         XM=XM/(1.0+FF)
      END IF
C     ++++++++++++
C
C ---- LIMITING OF DISCHARGE 
C
      IF(ABS(XM).LT.GX)XM=0.0
      IF(XM.GT.10.0*DD)XM=10.0*DD
      IF(XM.LT.-10.0*DD)XM=-10.0*DD
      M(I,J,2)=XM
C
      RETURN
      END
C ---------------------------------------------------------- 
      SUBROUTINE YMMT(GG,I,J,IFN,JFN,HZ,Z,DZ,DN,M,N,RX,FN)
C
      INTEGER I,J,IFN,JFN
      REAL    GG, RX, FN
      REAL    Z(IFN,JFN,2),M(IFN,JFN,2),N(IFN,JFN,2)
      REAL    DZ(IFN,JFN,2),HZ(IFN,JFN),DN(IFN,JFN,2)
	REAL    DD, XMM, FF, XN, XDN, XME, XNN0
C
      PARAMETER (GX=1.0E-5,GX2=1.0E-5)
C
      IF(J.EQ.JFN)THEN
         N(I,J,2)=0.0
         RETURN
      END IF
C
      IF(DZ(I,J,2).GT.GX)THEN
          IF(DZ(I,J+1,2).GT.GX)THEN
             DD=DN(I,J,2)
          ELSE
             IF(Z(I,J,2)+HZ(I,J+1).GT.GX)THEN
                DD=Z(I,J,2)+HZ(I,J+1)
             ELSE
                N(I,J,2)=0.0
                RETURN
             END IF
          END IF
      ELSE
          IF(DZ(I,J+1,2).GT.GX)THEN
             IF(Z(I,J+1,2)+HZ(I,J).GT.GX)THEN
                DD=Z(I,J+1,2)+HZ(I,J)
             ELSE
                N(I,J,2)=0.0
                RETURN
             END IF
          ELSE
             N(I,J,2)=0.0
             RETURN
          END IF
      END IF
C
C   ------  LINEAR TERM  ------
C
      IF(I.NE.1)THEN
         IF(DD.GE.GX)THEN
            XMM=0.25*(M(I,J,1)+M(I,J+1,1)+M(I-1,J,1)+M(I-1,J+1,1))
            FF=FN*SQRT(N(I,J,1)**2+XMM**2)/DD**(7.0/3.0)
            XN=(1.0-FF)*N(I,J,1)-GG*RX*DD*(Z(I,J+1,2)-Z(I,J,2))
         ELSE
            N(I,J,2)=0.0
            RETURN
         END IF
      ELSE
         N(I,J,2)=0.0
         RETURN
      END IF
C
C     ------  NON-LINEAR TERM  ------
C
C     ++++++++++++
      IF(I.GT.3.AND.I.LT.IFN-3.AND.J.GT.3.AND.J.LT.JFN-3)THEN
C     ++++++++++++
C
C     ************
      IF(DN(I,J,1).GE.GX)THEN
C     ************
C
      IF(N(I,J,1).GT.0.0)THEN
         IF(J.NE.1)THEN
            IF(DN(I,J-1,1).GE.GX)THEN
               XDN=N(I,J-1,1)**2/DN(I,J-1,1)
               IF(DZ(I,J-1,2).LT.GX)XDN=0.0
               IF(DZ(I,J,2).LT.GX)XDN=0.0
            ELSE
               XDN=0.0
            END IF
            XN=XN-RX*(N(I,J,1)**2/DN(I,J,1)-XDN) 
         END IF
      ELSE
         IF(DN(I,J+1,1).GE.GX)THEN
            XDN=N(I,J+1,1)**2/DN(I,J+1,1)
            IF(DZ(I,J+2,2).LT.GX)XDN=0.0
            IF(DZ(I,J+1,2).LT.GX)XDN=0.0
         ELSE
            XDN=0.0
         END IF
         XN=XN-RX*(XDN-N(I,J,1)**2/DN(I,J,1))
      END IF
C
      IF(XMM.GT.0.0)THEN
         IF(I.NE.2)THEN
            XME=0.25*(M(I-1,J,1)+M(I-1,J+1,1)+M(I-2,J,1)+M(I-2,J+1,1))
            IF(DN(I-1,J,1).GE.GX)THEN
               XDN=N(I-1,J,1)*XME/DN(I-1,J,1)
               IF(DZ(I-2,J,2).LT.GX)THEN
                  XDN=0.0
                  XNN0=XN-RX*(N(I,J,1)*XMM/DN(I,J,1)-XDN)
               ELSE
                  XNN0=XN-RX*(N(I,J,1)*XMM/DN(I,J,1)-XDN)
                  IF(DZ(I-2,J+1,2).LT.GX)XNN0=XN
                  IF(DZ(I-1,J,2).LT.GX)XNN0=XN
                  IF(DZ(I-1,J+1,2).LT.GX)XNN0=XN
               END IF
               XN=XNN0/(1.0+FF) 
            ELSE
               XDN=0.0
               XN=XN-RX*(N(I,J,1)*XMM/DN(I,J,1)-XDN)
               XN=XN/(1.0+FF)
            END IF
         END IF
      ELSE
         XME=0.25*(M(I+1,J,1)+M(I+1,J+1,1)+M(I,J,1)+M(I,J+1,1))
         IF(DN(I+1,J,1).GE.GX)THEN
            XDN=N(I+1,J,1)*XME/DN(I+1,J,1)
            IF(DZ(I+1,J,2).LT.GX)THEN
               XDN=0.0
               XNN0=XN-RX*(XDN-N(I,J,1)*XMM/DN(I,J,1))
            ELSE
               XNN0=XN-RX*(XDN-N(I,J,1)*XMM/DN(I,J,1))
               IF(DZ(I+2,J,2).LT.GX)XNN0=XN
               IF(DZ(I+1,J+1,2).LT.GX)XNN0=XN
               IF(DZ(I+2,J+1,2).LT.GX)XNN0=XN
            END IF
            XN=XNN0/(1.0+FF) 
         ELSE
            XDN=0.0
            XN=XN-RX*(XDN-N(I,J,1)*XMM/DN(I,J,1))
            XN=XN/(1.0+FF)
         END IF
      END IF
C
C     ************
      ELSE
         XN=XN/(1.0+FF)
      END IF
C     ************
C
C     ++++++++++++
      ELSE
         XN=XN/(1.0+FF)
      END IF
C     ++++++++++++
C
C ---- LIMITING OF DISCHARGE 
C
      IF(ABS(XN).LT.GX)XN=0.0
      IF(XN.GT.10.0*DD)XN=10.0*DD
      IF(XN.LT.-10.0*DD)XN=-10.0*DD
      N(I,J,2)=XN
C
      RETURN
      END
C
C ************** CONNECTION OF DISCHARGE *************
C
      SUBROUTINE JNQ(IX,JX,IY,JY,MX,NX,MY,NY,HY,L0,BCHK)
C
      INTEGER IX,JX,IY,JY,BCHK,CHK
      INTEGER L0(4)
	INTEGER ISS, JSS, IES, JES, ISL, JSL, IEL, JEL
	INTEGER I, J, II, JJ, IS, JS, KB
      REAL MX(IX,JX,2),NX(IX,JX,2)
      REAL MY(IY,JY,2),NY(IY,JY,2),HY(IY,JY)
	REAL SI, SJ, DI, DJ
C
C
      ISS=2
      JSS=2
      IES=IY
      JES=JY
      ISL=L0(1)
      JSL=L0(2)
      IEL=L0(3)
      JEL=L0(4)
      CHK=BCHK
      KB=CHK/1000
      IF(KB.EQ.1)THEN
         CHK=CHK-1000
         I=ISS
         J=JSS-1
         II=ISL-1
         JJ=JSL-1
         DO WHILE(I.LE.IES)
            SI=(I-ISS+2)/3.0
            IS=IFIX(SI)
            DI=SI-IS
            II=IS+ISL-1
            NY(I,J,2)=(1-DI)*NX(II,JJ,2)+DI*NX(II+1,JJ,2)
            IF(HY(I,J+1).LT.0.0)NY(I,J,2)=0.0
            I=I+1
         END DO
      END IF
C
      KB=CHK/100
      IF(KB.EQ.1)THEN
         CHK=CHK-100
         I=IES
         J=JSS
         II=IEL
         JJ=JSL-1
         DO WHILE(J.LE.JES)
            SJ=(J-JSS+2)/3.0
            JS=IFIX(SJ)
            DJ=SJ-JS
            JJ=JS+JSL-1
            MY(I,J,2)=(1-DJ)*MX(II,JJ,2)+DJ*MX(II,JJ+1,2)
            IF(HY(I,J).LT.0.0)MY(I,J,2)=0.0
            J=J+1
         END DO
      END IF
C
      KB=CHK/10
      IF(KB.EQ.1)THEN
         CHK=CHK-10
         I=ISS
         J=JES
         II=ISL-1
         JJ=JEL
         DO WHILE(I.LE.IES)
            SI=(I-ISS+2)/3.0
            IS=IFIX(SI)
            DI=SI-IS
            II=IS+ISL-1
            NY(I,J,2)=(1-DI)*NX(II,JJ,2)+DI*NX(II+1,JJ,2)
            IF(HY(I,J).LT.0.0)NY(I,J,2)=0.0
            I=I+1
         END DO
      END IF
C
      IF(CHK.EQ.1)THEN
         I=ISS-1
         J=JSS
         II=ISL-1
         JJ=JSL-1
         DO WHILE(J.LE.JES)
            SJ=(J-JSS+2)/3.0
            JS=IFIX(SJ)
            DJ=SJ-JS
            JJ=JS+JSL-1
            MY(I,J,2)=(1-DJ)*MX(II,JJ,2)+DJ*MX(II,JJ+1,2)
            IF(HY(I+1,J).LT.0.0)MY(I,J,2)=0.0
            J=J+1
         END DO
      END IF
      RETURN
      END
C
C *** EXCHANGE FOR LAST STEP DATA TO NEXT STEP DATA *****
C
      SUBROUTINE CHANGE(IFN,JFN,Z,M,N,DZ)
C
      INTEGER IFN, JFN
      REAL Z(IFN,JFN,2),M(IFN,JFN,2),N(IFN,JFN,2), DZ(IFN,JFN,2)
      DO 10 J=1,JFN
        DO 10 I=1,IFN
          Z(I,J,1)=Z(I,J,2)
          M(I,J,1)=M(I,J,2)
          N(I,J,1)=N(I,J,2)
		DZ(I,J,1)=DZ(I,J,2)
   10 CONTINUE
      RETURN
      END		
	   
C
C================================================================
C
C
C  ---------- SET PARAMETER ----------
C
      SUBROUTINE PARAME (R1,R2,R3,R4,R5,R6,C1,C2,H,IF1,JF1,DS,DT,YG,GX
     &)
      PARAMETER (GG=9.81)
      PARAMETER (PP=3.14159265)
      PARAMETER (R=6.378E+6,WW=7.2722E-5)
      REAL R1(IF1,JF1),R2(IF1,JF1),R3(IF1,JF1),R4(IF1,JF1),R5(IF1,JF1)
      REAL R6(JF1),C1(JF1),C2(JF1)
      REAL V1(JF1),V2(JF1),V3(JF1),V4(JF1),V5(JF1)
	REAL H(IF1,JF1)
C
      PX=PP/180                                     
      DX=R*(DS/60.)*PX       
      R0=DT/DX
	WRITE(*,*)' DS = ',DS
      WRITE(*,*)' PX = ',PX
      WRITE(*,*)' DX = ',DX
      WRITE(*,*)' R0 = ',R0
C
      DO I=1,IF1
         DO J=1,JF1
            R1(IF1,JF1)=0.
            R2(IF1,JF1)=0.
            R3(IF1,JF1)=0.
            R4(IF1,JF1)=0.
            R5(IF1,JF1)=0.                               
         ENDDO
      ENDDO
C
      DO J=1,JF1
         C1(J)=(YG+(DS*J-0.5*DS)/60.)*PX              
         C2(J)=(YG+DS*J/60)*PX                       
         R6(J)=COS(C1(J))
         V1(J)=R0/R6(J)
         V2(J)=GG*R0/R6(J)
         V3(J)=0.5*DT*WW*SIN(C1(J))
         V4(J)=GG*R0
         V5(J)=0.5*DT*WW*SIN(C2(J))
      ENDDO		 
C
      DO I=1,IF1
         DO J=1,JF1
            IF (H(I,J)<GX)  GOTO 30                    
               R1(I,J)=V1(J)                               
               R3(I,J)=V3(J)                             
               R5(I,J)=V5(J)                            
   30    CONTINUE
         ENDDO
      ENDDO
C
      DO I=1,IF1
         DO J=1,JF1
            IF (H(I,J)<GX)  GOTO 10                     
            IF (I/=IF1) THEN
               IF (H(I+1,J)<GX)  GOTO 10 
                  R2(I,J)=V2(J)*(H(I,J)+H(I+1,J))*0.5      
               ELSE
                  R2(I,J)=V2(J)*H(I,J)                         
               ENDIF
   10    CONTINUE
         ENDDO
      ENDDO
C
      DO I=1,IF1
         DO J=1,JF1
            IF (H(I,J)<GX)  GOTO 40                      
            IF (J/=JF1) THEN
               IF (H(I,J+1)<GX)  GOTO 40
                  R4(I,J)=V4(J)*(H(I,J)+H(I,J+1))*0.5        
               ELSE
                  R4(I,J)=V4(J)*H(I,J)                         
               ENDIF
   40    CONTINUE
         ENDDO
      ENDDO
      RETURN
      END
C
C  ---------- SET 1/SQRT(gH) ----------
C
      SUBROUTINE CF(IF1,JF1,CF1,CF2,CF3,CF4,H,GG,GX)
      REAL CF1(IF1), CF2(JF1), CF3(IF1), CF4(JF1), H(IF1,JF1)
C
      CF1(1:IF1)=0.
      CF2(1:JF1)=0.
      CF3(1:IF1)=0.
      CF4(1:JF1)=0.
C
      DO I=1,IF1
         IF(H(I,1)>GX) CF1(I)=1./SQRT(GG*H(I,1))             
         IF(H(I,JF1)>GX) CF3(I)=1./SQRT(GG*H(I,JF1))     
      ENDDO
C
      DO J=1,JF1
         IF(H(1,J)>GX) CF2(J)=1./SQRT(GG*H(1,J))            
         IF(H(IF1,J)>GX) CF4(J)=1./SQRT(GG*H(IF1,J))      
      ENDDO
      RETURN
      END
C
C================================================================
C
C
      SUBROUTINE ALIMIT (IG,JG,IS,JS,IE,JE)
C
      IS=2
      JS=2
      IE=IG-1
      JE=JG-1
      RETURN
      END					   
C
C  ---------- MASS FOR CAL. Z  ----------
C
      SUBROUTINE MASS (IF1,JF1,IS,JS,IE,JE,Z,M,N,R1,R6,GX,H)
C
      REAL   Z(IF1,JF1,2), M(IF1,JF1,2), N(IF1,JF1,2),H(IF1,JF1)
      REAL   R1(IF1,JF1), R6(JF1)
C
      DO J=JS,JE
         DO I=IS,IE
	      IF (H(I,J)<GX)  GOTO 10 
               Z(I,J,2)=Z(I,J,1)-R1(I,J)*(M(I,J,1)-M(I-1,J,1)+N(I,J,1)*R
     &6(J)-N(I,J-1,1)*R6(J-1))
C	****ADD****
            IF(ABS(Z(I,J,2))<1.0E-4) Z(I,J,2)=0.0
C	****ADD****
   10	   ENDDO
      ENDDO
C
      RETURN
      END
C
C
C  ---------- FOR CAL. Z AT EDGE ----------
      SUBROUTINE OPENBOUNDARY(IF1,JF1,IS,JS,IE,JE,Z,M,N,CF1,CF2,CF3,CF4
     &,H,GX)
C
      REAL   Z(IF1,JF1,2), M(IF1,JF1,2), N(IF1,JF1,2)
      REAL   CF1(IF1), CF2(JF1), CF3(IF1), CF4(JF1), H(IF1,JF1)
      REAL   V1, V2
C
C
C  ---------- J=1 -------------
      IF(JS<=2) THEN
         J=1
         DO I=2,IF1-1
            IF (H(I,J)<GX) GOTO 10
            V1=N(I,J,1)**2+0.25*(M(I,J,1)+M(I-1,J,1))**2
            V2=CF1(I)
            IF (N(I,J,1)>0.) V2=-V2
            Z(I,J,2)=V2*SQRT(V1)
C	****ADD****
		  IF(ABS(Z(I,J,2))<1.0E-4) Z(I,J,2)=0.0
C	****ADD****
   10    ENDDO
      ENDIF
C  ---------- J=JF1 -------------
      IF(JE>=JF1-1) THEN
         J=JF1
         DO I=2,IF1-1
            IF (H(I,J)<GX) GOTO 11
            V1=N(I,J-1,1)**2+0.25*(M(I,J,1)+M(I-1,J,1))**2
            V2=CF3(I)
            IF (N(I,J-1,1)<0.) V2=-V2
            Z(I,J,2)=V2*SQRT(V1)
C	****ADD****
		  IF(ABS(Z(I,J,2))<1.0E-4) Z(I,J,2)=0.0
C	****ADD****
   11    ENDDO
      ENDIF
C  
C  ---------- I=1 -------------
      IF(IS<=2) THEN
         I=1
         DO J=2,JF1-1
            IF (H(I,J)<GX) GOTO 12
            V1=M(I,J,1)**2+0.25*(N(I,J,1)+N(I,J-1,1))**2
            V2=CF2(J)
            IF (M(I,J,1)>0.) V2=-V2
            Z(I,J,2)=V2*SQRT(V1)
C	****ADD****
		  IF(ABS(Z(I,J,2))<1.0E-4) Z(I,J,2)=0.0
C	****ADD****
   12    ENDDO
      ENDIF
C  ---------- I=IF1 -------------
      IF(IE>=IF1-1) THEN
         I=IF1
         DO J=2,JF1-1
            IF (H(I,J)<GX) GOTO 13
            V1=M(I-1,J,1)**2+0.25*(N(I,J,1)+N(I,J-1,1))**2
            V2=CF4(J)
            IF (M(I-1,J,1)<0.) V2=-V2
            Z(I,J,2)=V2*SQRT(V1)
C	****ADD****
		  IF(ABS(Z(I,J,2))<1.0E-4) Z(I,J,2)=0.0
C	****ADD****
   13    ENDDO  
      ENDIF

C  ---------- AT CORNER ----------

      IF (H(1,1)<GX) GOTO 14
      Z(1,1,2)=SQRT(M(1,1,1)**2+N(1,1,1)**2)*CF1(1)
C	******ADD****
	IF(ABS(Z(I,J,2))<1.0E-4) Z(1,1,2)=0.0
C	******ADD****
      IF(N(1,1,1)>0.)  Z(1,1,2)=-Z(1,1,2)
C
   14 IF (H(IF1,1)<GX) GOTO 15
      Z(IF1,1,2)=SQRT(M(IF1-1,1,1)**2+N(IF1,1,1)**2)*CF1(IF1)
C	****ADD****
	IF(ABS(Z(IF1,1,2))<1.0E-4) Z(IF1,1,2)=0.0
C	****ADD****
      IF(N(IF1,1,1)>0.)  Z(IF1,1,2)=-Z(IF1,1,2)
C
   15  IF (H(1,JF1)<GX) GOTO 16
      Z(1,JF1,2)=SQRT(M(1,JF1,1)**2+N(1,JF1-1,1)**2)*CF3(1)
C	****ADD****
	IF(ABS(Z(1,JF1,2))<1.0E-4) Z(1,JF1,2)=0.0
C	****ADD****
      IF(N(1,JF1-1,1)<0.) Z(1,JF1,2)=-Z(1,JF1,2)
C
   16  IF (H(IF1,JF1)<GX) GOTO 17
      Z(IF1,JF1,2)=SQRT(M(IF1-1,JF1,1)**2+N(IF1,JF1-1,1)**2)*CF3(IF1)
C	****ADD****
	IF(ABS(Z(IF1,JF1,2))<1.0E-4) Z(IF1,JF1,2)=0.0
C	****ADD****
      IF(N(IF1,JF1-1,1)<0.) Z(IF1,JF1,2)=-Z(IF1,JF1,2)
C
   17 RETURN
      END
C
C  ---------- MOMENT FOR CAL.M AND N ----------
C
      SUBROUTINE MOMENT (IF1,JF1,IS,JS,IE,JE,Z,M,N,R2,R3,R4,R5,H,GX)
C
      REAL   Z(IF1,JF1,2), M(IF1,JF1,2), N(IF1,JF1,2), H(IF1,JF1)
      REAL   R2(IF1,JF1), R3(IF1,JF1), R4(IF1,JF1), R5(IF1,JF1)
      REAL   V1

C
C  ---------- M-DIRECTION ----------
      DO J=JS,JE
         DO I=IS,IE
            IF (H(I,J)<GX)GOTO 10
            V1=Z(I+1,J,2)-Z(I,J,2)
            IF (H(I+1,J)<GX)  V1=0.
            M(I,J,2)=M(I,J,1)-(R2(I,J)*V1-R3(I,J)*(N(I+1,J-1,1)+N(I+1,J,
     &1)+N(I,J-1,1)+N(I,J,1)))
   10    ENDDO
      ENDDO
C
      IF(IS<=2) THEN
         I=1
         DO J=1,JF1
	      IF (H(I,J)<GX)GOTO 20
            V1=Z(I+1,J,2)-Z(I,J,2)
            IF (H(I+1,J)<GX) V1=0.
            M(I,J,2)=M(I,J,1)-R2(I,J)*V1
   20    ENDDO
      ENDIF
C 
      IF(JE>=JF1-1) THEN
         J=JF1
         DO I=1,IF1-1
	      IF (H(I,J)<GX)GOTO 30
            V1=Z(I+1,J,2)-Z(I,J,2)
            IF (H(I+1,J)<GX) V1=0.
            M(I,J,2)=M(I,J,1)-R2(I,J)*V1
   30    ENDDO
      ENDIF
C
      IF(JS<=2) THEN
         J=1
         DO I=1,IF1-1
	      IF (H(I,J)<GX)GOTO 40
            V1=Z(I+1,J,2)-Z(I,J,2)
            IF (H(I+1,J)<GX) V1=0.
            M(I,J,2)=M(I,J,1)-R2(I,J)*V1
   40    ENDDO
      ENDIF
C
C  ---------- N-DIRECTION -----------
      DO J=JS,JE
         DO I=IS,IE
	      IF (H(I,J)<GX)GOTO 50
            V1=Z(I,J+1,2)-Z(I,J,2)
            IF (H(I,J+1)<GX) V1=0.
            N(I,J,2)=N(I,J,1)-(R4(I,J)*V1+R5(I,J)*(M(I-1,J+1,1)+M(I,J+1,
     &1)+M(I-1,J,1)+M(I,J,1)))
   50    ENDDO
      ENDDO
C
      IF(JS <= 2) THEN
         J=1
         DO I=1,IF1
	      IF (H(I,J)<GX)GOTO 60
            V1=Z(I,J+1,2)-Z(I,J,2)
            IF (H(I,J+1)<GX) V1=0.
            N(I,J,2)=N(I,J,1)-R4(I,J)*V1
   60    ENDDO
      ENDIF
C
      IF(IS <= 2) THEN
         I=1
         DO J=1,JF1-1
	      IF (H(I,J)<GX)GOTO 70
            V1=Z(I,J+1,2)-Z(I,J,2)
            IF (H(I,J+1)<GX) V1=0.
            N(I,J,2)=N(I,J,1)-R4(I,J)*V1
   70    ENDDO
      ENDIF
C
      IF(IE >= IF1-1) THEN
         I=IF1
         DO J=1,JF1-1
	      IF (H(I,J)<GX)GOTO 80
            V1=Z(I,J+1,2)-Z(I,J,2)
            IF (H(I,J)<GX) V1=0.
            N(I,J,2)=N(I,J,1)-R4(I,J)*V1
   80    ENDDO
      ENDIF
C
      RETURN
      END

C
C ************** CONNECTION OF DISCHARGE BETWEEN THE SPHERICAL AND CARTESIAN COORDINATE SYSTEM (N=8) *************
C
      SUBROUTINE JNQ_S2C(IX,JX,IY,JY,MX,NX,MY,NY,HY,L0,BCHK)
C
      INTEGER IX,JX,IY,JY,BCHK,CHK
      INTEGER L0(4)
	INTEGER ISS, JSS, IES, JES, ISL, JSL, IEL, JEL
	INTEGER I, J, II, JJ, IS, JS, KB
      REAL MX(IX,JX,2),NX(IX,JX,2)
      REAL MY(IY,JY,2),NY(IY,JY,2),HY(IY,JY)
	REAL SI, SJ, DI, DJ
C
C
      ISS=2
      JSS=2
      IES=IY
      JES=JY
      ISL=L0(1)
      JSL=L0(2)
      IEL=L0(3)
      JEL=L0(4)
      CHK=BCHK
      KB=CHK/1000
      IF(KB.EQ.1)THEN
         CHK=CHK-1000
         I=ISS
         J=JSS-1
         II=ISL-1
         JJ=JSL-1
         DO WHILE(I.LE.IES)
            SI=(I-ISS+4.5)/8.0
            IS=IFIX(SI)
            DI=SI-IS
            II=IS+ISL-1
            NY(I,J,2)=(1-DI)*NX(II,JJ,2)+DI*NX(II+1,JJ,2)
            IF(HY(I,J+1).LT.0.0)NY(I,J,2)=0.0
		  NY(I,J,1)=NY(I,J,2)
            I=I+1
         END DO
      END IF
C
      KB=CHK/100
      IF(KB.EQ.1)THEN
         CHK=CHK-100
         I=IES
         J=JSS
         II=IEL
         JJ=JSL-1
         DO WHILE(J.LE.JES)
            SJ=(J-JSS+4.5)/8.0
            JS=IFIX(SJ)
            DJ=SJ-JS
            JJ=JS+JSL-1
            MY(I,J,2)=(1-DJ)*MX(II,JJ,2)+DJ*MX(II,JJ+1,2)
            IF(HY(I,J).LT.0.0)MY(I,J,2)=0.0
		  MY(I,J,1)=MY(I,J,2)
            J=J+1
         END DO
      END IF
C
      KB=CHK/10
      IF(KB.EQ.1)THEN
         CHK=CHK-10
         I=ISS
         J=JES
         II=ISL-1
         JJ=JEL
         DO WHILE(I.LE.IES)
            SI=(I-ISS+4.5)/8.0
            IS=IFIX(SI)
            DI=SI-IS
            II=IS+ISL-1
            NY(I,J,2)=(1-DI)*NX(II,JJ,2)+DI*NX(II+1,JJ,2)
            IF(HY(I,J).LT.0.0)NY(I,J,2)=0.0
		  NY(I,J,1)=NY(I,J,2)
            I=I+1
         END DO
      END IF
C
      IF(CHK.EQ.1)THEN
         I=ISS-1
         J=JSS
         II=ISL-1
         JJ=JSL-1
         DO WHILE(J.LE.JES)
            SJ=(J-JSS+4.5)/8.0
            JS=IFIX(SJ)
            DJ=SJ-JS
            JJ=JS+JSL-1
            MY(I,J,2)=(1-DJ)*MX(II,JJ,2)+DJ*MX(II,JJ+1,2)
            IF(HY(I+1,J).LT.0.0)MY(I,J,2)=0.0
	      MY(I,J,1)=MY(I,J,2)
            J=J+1
         END DO
      END IF
      RETURN
      END




C
C ************** INTERPOLATION OF DISCHARGE IN TIME *************
C
      SUBROUTINE INTERQT (IFN,JFN,KK,NT,M,N,M_T,N_T)
C
      INTEGER IFN,JFN,KK,NT
      REAL M(IFN,JFN,2),N(IFN,JFN,2)
      REAL M_T(IFN,JFN,2),N_T(IFN,JFN,2)
C
      DO 10 J=1,JFN
		DO 10 I=1,IFN
			M_T(I,J,1)=M(I,J,1)
			N_T(I,J,1)=N(I,J,1)

			M_T(I,J,2)=M(I,J,1)+(M(I,J,2)-M(I,J,1))*KK/NT
			N_T(I,J,2)=N(I,J,1)+(N(I,J,2)-N(I,J,1))*KK/NT
   10 CONTINUE

      RETURN
      END

C
C ***************** WRITE WATER LEVEL Z TO FILE *****************
C
      SUBROUTINE OUTZ1(IFN,JFN,Z,K)
      REAL  Z(IFN,JFN,2)
	INTEGER IFN,JFN
      CHARACTER *30 FILENAME

      WRITE(FILENAME,'("Z1/Z",I5.5,".dat")') K
      OPEN(21,FILE=FILENAME)
      DO J=JFN,1,-1
        WRITE(21,'(301F10.3)')(Z(I,J,2),I=1,IFN)
      ENDDO
      CLOSE(21)
      RETURN
      END

      SUBROUTINE OUTZ2(IFN,JFN,Z,K)
      REAL  Z(IFN,JFN,2)
	INTEGER IFN,JFN
      CHARACTER *30 FILENAME

      WRITE(FILENAME,'("Z2/Z",I5.5,".dat")') K
      OPEN(21,FILE=FILENAME)
      DO J=JFN,1,-1
        WRITE(21,'(721F10.3)')(Z(I,J,2),I=1,IFN)
      ENDDO
      CLOSE(21)
      RETURN
      END

	SUBROUTINE OUTZ3(IFN,JFN,Z,K)
      REAL  Z(IFN,JFN,2)
	INTEGER IFN,JFN
      CHARACTER *30 FILENAME

      WRITE(FILENAME,'("Z3/Z",I5.5,".dat")') K
      OPEN(21,FILE=FILENAME)
      DO J=JFN,1,-1
        WRITE(21,'(637F10.3)')(Z(I,J,2),I=1,IFN)
      ENDDO
      CLOSE(21)
      RETURN
      END

	SUBROUTINE OUTZ4(IFN,JFN,Z,K)
      REAL  Z(IFN,JFN,2)
	INTEGER IFN,JFN
      CHARACTER *30 FILENAME

      WRITE(FILENAME,'("Z4/Z",I5.5,".dat")') K
      OPEN(21,FILE=FILENAME)
      DO J=JFN,1,-1
        WRITE(21,'(643F10.3)')(Z(I,J,2),I=1,IFN)
      ENDDO
      CLOSE(21)
      RETURN
      END

C	SUBROUTINE OUTZ (IFN,JFN,NDP,Z,FILE_ID)
C
C	INTEGER IFN,JFN,NDP,FILE_ID
C	REAL Z(IFN,JFN,2)
C     DO 10 J=JFN,1,-1
C		DO 10 I=1,IFN
C			IMOD=MOD(I-1,NDP)
C			JMOD=MOD(J-1,NDP)
C			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
C				WRITE(FILE_ID,'(F8.2)') Z(I,J,2)
C			ENDIF
C   10 CONTINUE
C
C      RETURN
C      END
C
C ***************** WRITE DISCHARGE M TO FILE *****************
C
      SUBROUTINE OUTM1 (IFN,JFN,M,K)
	INTEGER IFN,JFN
      REAL M(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("M1/M",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(301F10.3)')(M(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

	SUBROUTINE OUTM2 (IFN,JFN,M,K)
	INTEGER IFN,JFN
      REAL M(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("M2/M",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(721F10.3)')(M(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

	SUBROUTINE OUTM3 (IFN,JFN,M,K)
	INTEGER IFN,JFN
      REAL M(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("M3/M",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(637F10.3)')(M(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

	SUBROUTINE OUTM4 (IFN,JFN,M,K)
	INTEGER IFN,JFN
      REAL M(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("M4/M",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(643F10.3)')(M(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

C	SUBROUTINE OUTM (IFN,JFN,NDP,M,FILE_ID)
C
C	INTEGER IFN,JFN,NDP,FILE_ID
C	REAL M(IFN,JFN,2)
C
C      DO 10 J=JFN,1,-1
C		DO 10 I=1,IFN
C			IMOD=MOD(I-1,NDP)
C			JMOD=MOD(J-1,NDP)
C			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
C				WRITE(FILE_ID,'(F8.2)') M(I,J,2)
C			ENDIF
C   10 CONTINUE
C
C      RETURN
C      END
C
C ***************** WRITE DISCHARGE N TO FILE *****************
C


      SUBROUTINE OUTN1 (IFN,JFN,N,K)
	INTEGER IFN,JFN
      REAL N(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("N1/N",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(301F10.3)')(N(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

	SUBROUTINE OUTN2 (IFN,JFN,N,K)
	INTEGER IFN,JFN
      REAL N(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("N2/N",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(721F10.3)')(N(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

	SUBROUTINE OUTN3 (IFN,JFN,N,K)
	INTEGER IFN,JFN
      REAL N(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("N3/N",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(637F10.3)')(N(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END

	SUBROUTINE OUTN4 (IFN,JFN,N,K)
	INTEGER IFN,JFN
      REAL N(IFN,JFN,2)
	CHARACTER *30 FILENAME

	WRITE(FILENAME,'("N4/N",I5.5,".dat")') K
	OPEN(21,FILE=FILENAME)
	DO J=JFN,1,-1
		WRITE(21,'(643F10.3)')(N(I,J,2),I=1,IFN)
	ENDDO
	CLOSE(21)
	RETURN
	END


C	SUBROUTINE OUTN (IFN,JFN,NDP,N,FILE_ID)
C
C	INTEGER IFN,JFN,NDP,FILE_ID
C	REAL N(IFN,JFN,2)
C
C      DO 10 J=JFN,1,-1
C		DO 10 I=1,IFN
C			IMOD=MOD(I-1,NDP)
C			JMOD=MOD(J-1,NDP)
C			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
C				WRITE(FILE_ID,'(F8.2)') N(I,J,2)
C			ENDIF
C   10 CONTINUE
C
C      RETURN
C      END
C
C     ********* UPDATING MAXIMUM Z ***********
C
      SUBROUTINE ZMAX(IFN,JFN,Z,ZM)
C
      INTEGER   IFN, JFN
      REAL      Z(IFN,JFN,2), ZM(IFN,JFN)
C
      DO J=1, JFN
         DO I=1, IFN
            IF (ZM(I,J) .LT. Z(I,J,2)) ZM(I,J) = Z(I,J,2)
         END DO
      END DO
      RETURN
      END
C
C ***************** WRITE MAXIMUM WATER LEVEL ZM TO FILE *****************
C
	SUBROUTINE OUTZMAX (IFN,JFN,NDP,ZM,FILE_ID)
C
	INTEGER IFN,JFN,NDP,FILE_ID
	REAL ZM(IFN,JFN)

      DO 10 J=JFN,1,-1
		DO 10 I=1,IFN
			IMOD=MOD(I-1,NDP)
			JMOD=MOD(J-1,NDP)
			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
				WRITE(FILE_ID,'(F8.2)') ZM(I,J)
			ENDIF
   10 CONTINUE
      RETURN
      END
C
C  ********* OUTPUT OF TIME HISTORIES *********
C
	SUBROUTINE  POINT(IFN,JFN,Z,M,N,NP,IP,JP,PZ,PM,PN,TM,NPNT,NPMM,NPNN)  
C
      INTEGER   IFN,JFN,NP,IP(NP),JP(NP),NPNT,NPMM,NPNN
      REAL      Z(IFN,JFN,2),M(IFN,JFN,2),N(IFN,JFN,2),PZ(NP),TM
	REAL	  PM(NP), PN(NP)
C
      DO I=1, NP
	     PZ(I)=Z(IP(I),JP(I),2)	
	   	 PM(I)=M(IP(I),JP(I),2)
		 PN(I)=N(IP(I),JP(I),2)
      END DO
C
      WRITE(NPNT,'(F8.2,100F8.3)') TM, (PZ(I),I=1,NP)
      WRITE(NPMM,'(F8.2,100F8.3)') TM, (PM(I),I=1,NP)
      WRITE(NPNN,'(F8.2,100F8.3)') TM, (PN(I),I=1,NP)
      RETURN
      END
C
C  ----------  ADJUST DEPTH AT EDGE  ----------
C
      SUBROUTINE GIORS (IF1,JF1,GX,H)
      INTEGER     IF1, JF1, L
      REAL        GX
      REAL        H(IF1,JF1)
      L=0
      I=1
      DO J=1,JF1
         IF(H(I,J) > GX .AND. H(I+1,J) < GX) THEN
            H(I,J)=H(I+1,J)
            WRITE(*,'(1X,A4,1X,A2,I4,1X,A2,I4)') 'LEFT','I=',I,'J=',J
            L=L+1
         ENDIF
      ENDDO
C
      I=IF1
      DO J=1,JF1
         IF(H(I,J) > GX .AND. H(I-1,J) < GX) THEN
            H(I,J)=H(I-1,J)
            WRITE(*,'(1X,A5,1X,A2,I4,1X,A2,I4)') 'RIGHT','I=',I,'J=',J
            L=L+1
         ENDIF
      ENDDO
C
      J=1
      DO I=1,IF1
         IF(H(I,J) > GX .AND. H(I,J+1) < GX) THEN
            H(I,J)=H(I,J+1)
            WRITE(*,'(1X,A4,1X,A2,I4,1X,A2,I4)') 'DOWN','I=',I,'J=',J
            L=L+1
         ENDIF
      ENDDO
C 
      J=JF1
      DO I=1,IF1
         IF(H(I,J) > GX .AND. H(I,J-1) < GX) THEN
            H(I,J)=H(I,J-1)
            WRITE(*,'(1X,A2,1X,A2,I4,1X,A2,I4)') 'UP','I=',I,'J=',J
            L=L+1
         ENDIF
      ENDDO
C
      WRITE(*,'(1X,A3,I4)') 'L=',L
C
      RETURN
      END
C
C ---------- ADJUST Z=H FOR LAND ----------
C
      SUBROUTINE DPCHANGE (IF1,JF1,H,Z,GX)
      REAL H(IF1,JF1),Z(IF1,JF1,2)
	REAL GX
C
      DO I=1,IF1
         DO J=1,JF1
            IF (H(I,J)<GX) THEN
               Z(I,J,1)=H(I,J)
               Z(I,J,2)=H(I,J)
            ENDIF
         ENDDO
      ENDDO
      RETURN
      END
C
C     ********* UPDATING MAXIMUM MN ***********
C
      SUBROUTINE MNMAX(IFN,JFN,M,N,Z,MM,NM,ZMN)
C
      INTEGER   IFN, JFN
      REAL      M(IFN,JFN,2),N(IFN,JFN,2),MM(IFN,JFN),NM(IFN,JFN)
      REAL	  TEMPMN ,TEMPMNMAX, Z(IFN,JFN,2),ZMN(IFN,JFN)
C
      DO J=1, JFN
         DO I=1, IFN
	    TEMPMN = SQRT(M(I,J,2)**2+N(I,J,2)**2)
	    TEMPMNMAX = SQRT(MM(I,J)**2+NM(I,J)**2)	
            IF (TEMPMNMAX .LT. TEMPMN) THEN
	       MM(I,J) = M(I,J,2)
	       NM(I,J) = N(I,J,2)
	       ZMN(I,J) = Z(I,J,2)
	    END IF
         END DO
      END DO
      RETURN
      END
C
C ***************** WRITE MAXIMUM M TO FILE *****************
C
	SUBROUTINE OUTMMAX (IFN,JFN,NDP,MM,FILE_ID)
C
	INTEGER IFN,JFN,NDP,FILE_ID
	REAL MM(IFN,JFN)

      DO 10 J=JFN,1,-1
		DO 10 I=1,IFN
			IMOD=MOD(I-1,NDP)
			JMOD=MOD(J-1,NDP)
			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
				WRITE(FILE_ID,'(F8.2)') MM(I,J)
			ENDIF
   10 CONTINUE
      RETURN
      END
C
C ***************** WRITE MAXIMUM N TO FILE *****************
C
	SUBROUTINE OUTNMAX (IFN,JFN,NDP,NM,FILE_ID)
C
	INTEGER IFN,JFN,NDP,FILE_ID
	REAL NM(IFN,JFN)

      DO 10 J=JFN,1,-1
		DO 10 I=1,IFN
			IMOD=MOD(I-1,NDP)
			JMOD=MOD(J-1,NDP)
			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
				WRITE(FILE_ID,'(F8.2)') NM(I,J)
			ENDIF
   10 CONTINUE
      RETURN
      END
C
C ***************** WRITE Z @ MAXIMUM MN TO FILE *****************
C
	SUBROUTINE OUTZMNMAX (IFN,JFN,NDP,ZMN,FILE_ID)
C
	INTEGER IFN,JFN,NDP,FILE_ID
	REAL ZMN(IFN,JFN)

      DO 10 J=JFN,1,-1
		DO 10 I=1,IFN
			IMOD=MOD(I-1,NDP)
			JMOD=MOD(J-1,NDP)
			IF (IMOD.EQ.0 .AND. JMOD.EQ.0) THEN
				WRITE(FILE_ID,'(F8.2)') ZMN(I,J)
			ENDIF
   10 CONTINUE
      RETURN
      END
